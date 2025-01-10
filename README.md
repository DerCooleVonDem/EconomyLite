<div align="center">
  <h1>EconomyLite</h1>
  <p>The simple economy plugin for stable currencys</p>
  <p>No weird formattings, no weird design choices, no UIs</p>
  <a href="https://poggit.pmmp.io/p/EconomyLite"><img src="https://poggit.pmmp.io/shield.state/EconomyLite"></a>
</div>

## Overview
**EconomyLite** is a compact and lightweight economy management plugin for PocketMine. Its goal is to provide a simple way to integrate an economy system into your Minecraft server without unnecessary complexity or bloated features, while ensuring stability and customization.

### Key Features:
- **Minimalistic Design**: Simple and focused on core economy features. No intrusive user interface or complicated formatting.
- **Player Accounts**: Automatically manages player accounts for new and existing players.
- **Configurable Economy**: Allows you to configure the starting money, maximum money limit, and more via the configuration files.
- **Administrator Tools**: Includes admin commands to manage player balances, view transaction histories, and monitor the overall economy.
- **Transaction History**: Automatically logs recent payments for players and admins.
- **Localization Support**: All messages can be customized through the `language.yml` file to fit your server's language needs.

## Commands

### Player Commands
These commands are available to all players based on their permissions:

| Command | Description | Permission |
| --- | --- | --- |
| **/pay `<name>` `<amount>`** | Pay another player a certain amount | economylite.cmd.pay |
| **/purse** | Display your balance and recent payments | economylite.cmd.purse |

### Admin Commands
Admin commands allow server operators to configure and manage the economy:

| Command | Description | Permission |
| --- | --- | --- |
| **/economylite** `<sub>` | Base command for admin subcommands | economylite.command |
| **/economylite help** | Shows available admin commands | economylite.sub.help |
| **/economylite add `<name>` `<amount>`** | Adds money to a player's account | economylite.sub.add |
| **/economylite remove `<name>` `<amount>`** | Removes money from a player's account | economylite.sub.remove |
| **/economylite show `<name>`** | Displays a player's balance | economylite.sub.show |
| **/economylite delete `<name>`** | Deletes a player's account | economylite.sub.delete |
| **/economylite info** | Displays general economy statistics | economylite.sub.info |
| **/economylite history `<name>` [limit=100]** | Shows payment history of a specific player | economylite.sub.history |

## Detailed Features:
1. **Player Account Management**:
    - **Automatic Account Creation**: Player accounts are created automatically when they join the server for the first time.
    - **Configurable Starting Balance**: New players receive a starting balance (configurable in the plugin settings).

2. **Simple Transactions**:
    - Players can transfer money using the `/pay` command.
    - Invalid transactions (e.g., insufficient funds, invalid targets) are gracefully handled.

3. **Command Breakdown**:
    - `/purse`: Shows the player's current balance and the last five transactions (both sent and received).
    - `/pay`: Lets players send money to others, provided they have sufficient balance.

4. **Admin Features**:
    - Manage economy balance:
        - **Add** or **Remove** money from a specific player's account.
        - **Delete** a player account entirely, removing it from the database.

    - Query balance for any player using the `/economylite show` command.
    - Global economy statistics are available using `/economylite info`, such as:
        - Total money in circulation.
        - Recent changes (e.g., added or removed money).

    - Review player payment history through `/economylite history`.

5. **Economy Limits**:
    - Enforces a configurable maximum economy cap to prevent exceeding defined limits.
    - Transactions that surpass the configured money cap are denied to maintain balance.

6. **History and Logging**:
    - Payment history and economy changes are logged internally and can be queried using commands.
    - Admins can retrieve detailed player transaction logs, filtered by limits.

7. **Localization**:
    - All plugin messages are stored in `language.yml`, which supports customization.
    - Default values are restored automatically if keys are missing from the configuration.

## Player Usage
### Sending Money:
To send money to another player:
``` bash
/pay <player_name> <amount>
```
Example: To send 500 currency to a player named "Alex":
``` bash
/pay Alex 500
```
### Checking Balance:
To view your current balance and recent payment history:
``` bash
/purse
```

## Admin Usage
### Add or Remove Money:
Add or remove money from a player's account:
``` bash
/economylite add <player_name> <amount>
/economylite remove <player_name> <amount>
```
Example: Add 1000 currency to "Alex":
``` bash
/economylite add Alex 1000
```
### Delete a Player Account:
Delete an account completely:
``` bash
/economylite delete <player_name>
```
### Payment History:
View transaction logs for specific players:
``` bash
/economylite history <player_name> [limit=100]
```
### Economy Info:
View the current state of the server's economy:
``` bash
/economylite info
```

## Configuration
The plugin includes a configuration file (`config.yml`), where you can modify:
- **Starting Money**: Set the default balance for new players.
- **Maximum Economy Cap**: The total cap for money in circulation.

## Library's in use
- **libasynql** https://github.com/poggit/libasynql

## Disclaimer
This plugin is currently in active development and is released for feedback. It is not recommended for production use without proper testing in your environment.
**Use at your own risk.**
### For Developers

This section is still under development. You can explore the source code, particularly the `EconomyLite.php` file, for an overview of the internal API.

Feel free to leave feedback or issues on the project’s [Poggit page - Unreleased]().