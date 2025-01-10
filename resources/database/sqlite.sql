-- #!sqlite

-- #{ table
    -- #{ economy
            CREATE TABLE IF NOT EXISTS economy (
                player TEXT PRIMARY KEY,
                money INTEGER
            );
    -- #}
    -- #{ payment_history
            CREATE TABLE IF NOT EXISTS payment_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                sender TEXT,
                receiver TEXT,
                money INTEGER,
                date TEXT
            );
    -- #}
    -- #{ economy_changes
            CREATE TABLE IF NOT EXISTS economy_changes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                player TEXT,
                money INTEGER,
                date TEXT
            );
    -- #}
-- #}

-- #{ data
    -- #{ economy
        -- #{ add_player
            -- # :player string
            -- # :money int
            INSERT OR REPLACE INTO economy(player, money)
            VALUES (:player, :money);
        -- #}
        -- #{ get
            -- # :player string
            SELECT money FROM economy WHERE player = :player;
        -- #}
        -- #{ add
            -- # :player string
            -- # :money int
            UPDATE economy SET money = money + :money WHERE player = :player;
        -- #}
        -- #{ remove
            -- # :player string
            -- # :money int
            UPDATE economy SET money = money - :money WHERE player = :player;
        -- #}
        -- #{ all
            SELECT SUM(money) AS total_money FROM economy;
        -- #}
        -- #{ delete_player
            -- # :player string
            DELETE FROM economy WHERE player = :player;
        -- #}
        -- #{ set
            -- # :player string
            -- # :money int
            INSERT INTO economy(player, money) VALUES (:player, :money);
        -- #}
    -- #}

    -- #{ payment_history
        -- #{ add
            -- # :sender string
            -- # :receiver string
            -- # :money int
            -- # :date string
            INSERT INTO payment_history(sender, receiver, money, date)
            VALUES (:sender, :receiver, :money, :date);
        -- #}
        -- #{ get
            -- # :player string
            SELECT * FROM payment_history
            WHERE sender = :player OR receiver = :player
            ORDER BY date DESC;
        -- #}
    -- #}

    -- #{ economy_changes
        -- #{ add
            -- # :player string
            -- # :money int
            -- # :date string
            INSERT INTO economy_changes(player, money, date)
            VALUES (:player, :money, :date);
        -- #}
        -- #{ all
            SELECT * FROM economy_changes ORDER BY date DESC;
        -- #}
    -- #}
-- #}
