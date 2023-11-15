# Installation Guide:

1. git clone https://github.com/Dawd22/CompetitionManagerPage.git
2. cd CompetitionManagerPage/CompetitionManager
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. php artisan migrate --seed
7. php artisan serve

# Date Handling in the Application

## Competition 

- The start year cannot be earlier than the current year.
- The start year can range up to the year 2040.

## Rounds 

- Each round within a competition is associated with a specific date.
- The date of a round must be equal to or later than the start date of the competition to which it belongs.
- Rounds cannot overlap.
- The date of a round cannot extend beyond the year 2040.
  
# User Handling in the Application

## Users
- The `users` table is populated with some dummy data through migrations. However, if you want to add a competitor who is not already in the `users` table, the application will create the user.

