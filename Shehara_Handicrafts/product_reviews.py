from flask import Flask, render_template, request, session, redirect, url_for, flash
import pymysql
import secrets

app = Flask(__name__)
app.secret_key = secrets.token_hex(32)  # Generates a secure random 64-character hex string

@app.before_request
def set_session_for_testing():
    # Remove forced user_id. Only set user_id if it exists in the session (from PHP login)
    # Do NOT clear the session here, so PHP session persists across requests
    try:
        import phpserialize
        import os
        from flask import request
        session_cookie = request.cookies.get('PHPSESSID')
        if session_cookie:
            session_file = f"c:/xampp/tmp/sess_{session_cookie}"
            if os.path.exists(session_file):
                with open(session_file, 'rb') as f:
                    data = f.read()
                try:
                    # Use phpserialize.session_decode for PHP session files (handles opcodes)
                    session_data = phpserialize.session_decode(data, decode_strings=True)
                    php_user_id = session_data.get('user_id')
                    if php_user_id:
                        session['user_id'] = int(php_user_id)
                        print(f"PHP session user_id found: {session['user_id']}")  # Debug
                except Exception as e:
                    print(f"Error reading PHP session: {e}")
    except ImportError:
        print("phpserialize not installed, skipping PHP session read.")

    # Fallback for testing only if user_id is not set
    if 'user_id' not in session or not isinstance(session['user_id'], int):
        session['user_id'] = 8  # Set your test user_id here if needed
        print(f"Fallback user_id set: {session['user_id']}")  # Debug

def get_db_connection():
    return pymysql.connect(
        host='192.168.242.140',
        user='shehara',
        password='Osuri@123',
        db='shehara_handicrafts',
       cursorclass=pymysql.cursors.DictCursor
    )

@app.route('/product_reviews', methods=['GET', 'POST'])
def product_reviews():
    # Get user_id and product_id from query params (URL) if present, else from session
    user_id = request.args.get('user_id', type=int) or session.get('user_id', 0)
    product_id = request.args.get('product_id', type=int) or 0
    session['user_id'] = user_id  # Optionally update session for consistency

    print(f"GET user_id: {user_id}, product_id: {product_id}")  # Debug

    con = get_db_connection()
    try:
        with con.cursor() as cur:
            # Fetch product info
            cur.execute("SELECT * FROM products WHERE product_id = %s", (product_id,))
            product = cur.fetchone()
            if not product:
                return "Product not found.", 404

            # Handle review submission
            if request.method == 'POST' and user_id:
                rating = int(request.form['rating'])
                review = request.form['review'].strip()

                print(f"user_id: {user_id}, product_id: {product_id}")

                # Debug: check if user_id exists in orders
                cur.execute("SELECT * FROM orders WHERE user_table_user_id = %s", (user_id,))
                user_orders = cur.fetchall()
                print(f"user_orders for user_id {user_id}: {user_orders}")

                # Debug: check if product_id exists in order_items
                cur.execute("SELECT * FROM order_items WHERE products_product_id = %s", (product_id,))
                product_orders = cur.fetchall()
                print(f"order_items for product_id {product_id}: {product_orders}")

                # If user_orders is empty, user has not placed any orders
                if not user_orders:
                    flash("You have not placed any orders with this account.", "danger")
                else:
                    # Now check if any of the user's orders contain this product
                    order_ids = [order['order_id'] for order in user_orders]
                    # Convert order_ids to a tuple for SQL IN clause
                    if not order_ids:
                        bought = None
                    else:
                        # Always convert order_ids to string for SQL, and handle single value tuple
                        if len(order_ids) == 1:
                            order_ids_tuple = (order_ids[0],)
                        else:
                            order_ids_tuple = tuple(order_ids)
                        format_strings = ','.join(['%s'] * len(order_ids_tuple))
                        cur.execute(
                            f"SELECT * FROM order_items WHERE order_order_id IN ({format_strings}) AND products_product_id = %s",
                            (*order_ids_tuple, product_id)
                        )
                        bought = cur.fetchone()
                    print(f"bought (user's orders for this product): {bought}")

                    if bought:
                        # Prevent duplicate review (check for this user and this product only)
                        cur.execute("SELECT * FROM product_reviews WHERE product_id = %s AND user_id = %s", (product_id, user_id))
                        already = cur.fetchone()
                        print(f"already: {already}")
                        if not already:
                            cur.execute("""
                                INSERT INTO product_reviews (product_id, user_id, rating, review, status, created_at)
                                VALUES (%s, %s, %s, %s, 'approved', NOW())
                            """, (product_id, user_id, rating, review))
                            con.commit()
                            print("Review inserted")
                            flash("Thank you for your review!", "success")
                        else:
                            flash("You have already reviewed this product. If you want to update your review, please contact support.", "danger")
                    else:
                        flash("You can only review products you have purchased.", "danger")

            # Fetch reviews
            cur.execute("""
                SELECT r.*, u.first_name, u.last_name FROM product_reviews r
                JOIN user_table u ON r.user_id = u.user_id
                WHERE r.product_id = %s AND r.status = 'approved'
                ORDER BY r.created_at DESC
            """, (product_id,))
            reviews = cur.fetchall()

        return render_template('product_reviews.html', product=product, reviews=reviews)
    finally:
        con.close()

# ...existing code for app run and other routes...

if __name__ == '__main__':
    app.run(debug=True)
