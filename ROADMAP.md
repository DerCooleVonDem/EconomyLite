# EconomyLite - Roadmap
🚀 Lightweight and straightforward economy management plugin for PocketMine 🌐
Here's what's coming in future updates! 🎉

## Roadmap Overview
EconomyLite is a simple, reliable, and lightweight PocketMine economy plugin. As I aim to deliver new and exciting features while maintaining the plugin's simplicity, here is my **roadmap** for features I plan to introduce in future updates.
My focus is on providing server owners and players with more tools to enhance their in-game economy experience, while keeping performance fast and efficient.

## Disclaimer
**All features described here are planned. Everything may change in future commits or updates and is subject to modification.**

## Planned Features
### 1. **Bank Accounts**
- **Description**:
    - Introduce a bank system where players can deposit or withdraw money.
    - Divide player balances into "wallet" (purse) and "bank account."
    - Add optional features like interest on savings to reward players for storing money in the bank.

- **Benefits**:
    - Encourages better money management.
    - Adds realism and new gameplay possibilities.

- **Planned Commands**:
    - `/bank deposit <amount>` – Deposit money into your bank account.
    - `/bank withdraw <amount>` – Withdraw money from your bank account.
    - `/bank balance` – Check your bank account balance.

### 2. **Taxation System**
- **Description**:
    - Implement configurable taxes applied to transactions or as periodic fees deducted from player accounts.
    - Support percentage-based taxes on payments (e.g., `/pay`) or regular time-based taxation.

- **Benefits**:
    - Adds realism to economy servers with governments or roleplay themes.
    - Provides a sink for money to reduce inflation.

- **Planned Configuration**:
    - Enable/Disable taxes globally or for specific transaction types.
    - Configure tax rates and exemptions for specific player groups.

### 3. **Dynamic Economy System**
- **Description**:
    - Introduce inflation and deflation mechanics to simulate a dynamic economy.
    - Adjust transaction fees, maximum player balances, or currency values based on total money in circulation.
    - Include configuration options to enable or disable this feature for servers that prefer stability.

- **Benefits**:
    - Ensures the economy remains balanced over time.
    - Creates interesting challenges for admins and players to adapt their strategies.

- **Planned Features**:
    - Configurable thresholds for inflation/deflation triggers.
    - Notifications for admins when major economic shifts occur.

### 4. **Leaderboards**
- **Description**:
    - Add a leaderboard system displaying the richest players on the server.
    - Display rankings based on wallet balance, bank balance, or total wealth.

- **Benefits**:
    - Encourages player competition to climb the leaderboard.
    - Adds visibility to player achievements in the economy.

- **Planned Features**:
    - Show the top 10 players via a command (e.g., `/economylite leaderboard`).
    - Option to integrate with a scoreboard or external plugins for display.

### 5. **Multi-Currency Support**
- **Description**:
    - Allow servers to define multiple currencies (e.g., gold coins, diamonds, other custom units).
    - Support configurable exchange rates between currencies.
    - Allow transactions and balances to be conducted in different currencies.

- **Benefits**:
    - Useful for servers with diverse settings or lore-based economies.
    - Adds complexity and player choice in economic systems.

- **Planned Configuration**:
    - Define multiple currency names and symbols in the config file.
    - Configure which currency is used for `/pay` and other commands.

### 6. **Fines System**
- **Description**:
    - Let admins or automated systems impose fines on players for rule-breaking or failing objectives.
    - Define penalties that deduct a fixed amount or percentage from a player's balance.

- **Benefits**:
    - Provides a non-intrusive way to enforce rules.
    - Adds realism and accountability for players in roleplay or job-related scenarios.

- **Planned Features**:
    - Fines applied automatically based on conditions (e.g., penalties for specific events or actions).
    - Commands like `/economylite fine <player> <type>` for manual fines.

### 7. **Economy Analytics Update**
- **Description**:
    - Add advanced analytics for admins to monitor the state of the server's economy.
    - Data presented through commands and logs to include:
        - Average player balance.
        - Richest/poorest player stats.
        - Total money in circulation over time.

- **Benefits**:
    - Helps admins maintain a healthy, functional economy.
    - Offers insight into economic trends and problem areas (e.g., inflation).

- **Planned Commands**:
    - `/economylite stats` – View summary analytics of the server’s economy.
    - `/economylite trends` – View historical economy data (e.g., charts/logs).

### 8. **Customizable Currency Design**
- **Description**:
    - Allow admins to define custom currency formatting, symbols, and names.
    - Multi-language support for different servers.

- **Benefits**:
    - Enhances immersion for custom server settings (e.g., fantasy or role-play themes).
    - Provides better branding options for server economics.

- **Planned Configuration**:
    - Use `config.yml` to customize currency names and symbols globally.
    - Per-command customization to display different formats.

### 9. **Transaction Limits**
- **Description**:
    - Add configurable limits for transactions to prevent abuse.
    - Features include:
        - Daily transaction caps (per player or per group).
        - Cooldowns between transaction attempts.

- **Benefits**:
    - Regulates high-value transactions to prevent sudden balance shifts.
    - Prevents spam or exploitative behavior during transactions.

- **Planned Features**:
    - Configurable limits for `/pay` commands.
    - Alerts to players about their daily transaction progress.

### 10. **Anti-Exploit Safeguards**
- **Description**:
    - Implement a robust system to detect and block unusual or exploitative transactions.
    - Features include:
        - Duplicate transaction prevention.
        - Monitoring of suspicious money transfers (e.g., very large transfers).

- **Benefits**:
    - Ensures server economy integrity.
    - Automatically stops exploits, reducing admin intervention.

- **Planned Features**:
    - Notify admins when suspicious activity is detected.
    - Option to temporarily block flagged players from transactions until reviewed.

## Development Stages
To implement these features, the following development stages have been identified:
1. **Core System Improvements**:
    - Prepare internal architecture to support advanced features like multi-currency, analytics, and dynamic economies.

2. **Player-Focused Additions**:
    - Introduce player-facing features like bank accounts, leaderboards, and fines.

3. **Administrative Tools**:
    - Roll out analytics, taxation, and safeguard systems to help admins monitor and stabilize the economy.

4. **Polish and Optimization**:
    - Finalize features with robust testing and ensure performance remains lightweight.