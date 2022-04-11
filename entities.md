

User - Log in of the user, links to the data
 Budget - Holds all of the data to a "Budget", accounts, budget month, payees, etc 
  Account - A single account under a budget, holds transactions
   Transaction - A single transaction under an account
 Payee - A payee, linked into a Transaction
 Category - A category, linked into a Transaction
 BudgetMonth - Budget for a particular Year/Month
  BudgetMonthCategory - Details for this particular month budget for a single category

Each budget will have YYYYMM records for each month of the year, this will hold details for the budget
 - BudgetMonth (202201)
  - Credit Card Payments
  - Categories
   - Assigned
   - Activity (Transactions for this BudgetMonth)
   - Available (Assigned - Activity)

Special Categories for use in BudgetMonths
 - Unassigned - This is the amount unassigned, income will go here by default
 - Credit Card Payments - One for each credit card, when purchase is made on a credit card this get activity, transfer from "money" account to clear.

