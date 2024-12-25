<div align="center">
  <h1>EconomyLite</h1>
  <p>The simple economy plugin for stable currencys</p>
  <p>No weird formattings, no weird design choices, no UIs</p>
</div>

## For Developers
This secion is under development, please refer to EconomyLite.php in the source directory of my repo.

# Feautures
- Starting money on first join
- Limit how much money can be in exchange at once
- Payments
- Economy changes are logged for admins
- Payment History

# Commands
Command | Description | Permission
--- | --- | ---
`/economylite <sub>` | Contains useful subcommands to administerate the economy | economylite.command
`/pay <name> <amount>` | Pay someone | economylite.cmd.pay
`/purse` | Shows your current balance and recent payments | economylite.cmd.purse

# Economylite Admin Commands
Command | Description | Permission
--- | --- | ---
`/economylite help` | Help about the economylite commands | economylite.sub.help
`/economylite add <name> <amount>` | Adds money into the economy | economylite.sub.add
`/economylite remove <name> <amount>` | Removes money from the economy | economylite.sub.remove
`/economylite info` | Get information about the economy | economylite.sub.info
`/economylite show <name>` | Shows the balance of a player | economylite.sub.show
`/economylite delete <name>` | Deletes the account of a player | economylite.sub.delete
`/economylite history <name> [limit=100]` | Displays the payment history of given player | economylite.sub.history

# Disclaimer
This project is currently undergoing development and is released for feedback. I do not recommend using it in production, if you will then its on your own risk.
