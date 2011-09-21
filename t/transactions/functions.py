from django.db import connection, transaction


def run_rules(user_id):
    """
    Updates all the user's transactions based on their current rules.
    """
    cursor = connection.cursor()

    cursor.execute(
        """
        update transactions_transaction t, `transactions_rule` r
        set t.category_id = r.category_id
        where t.user_id = %d
        and lower(t.description) like concat('%', lower(r.value), '%');
        """,
        [user_id]
    )

    transaction.commit_unless_managed()