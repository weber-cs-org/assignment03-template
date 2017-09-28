# Assignment 03 - Points **120**

## Instructions

This assignment contains code from `Assignment 02` so do not be surprised. It picks up where `Assignment 02` left off.

### 00 - User Class

- Create a file named `User.php` in the `src/` directory.
- Create a class named `User` that has two public properties named `$email` and `$name`. (DO NOT DO IN PRODUCTION!)
- Create a constructor that takes two arguments named `$email` and `$name`.
- Validate the constructors two arguments.  Meaning the email needs to be a valid email address and that name cannot take an integer.
- The class constructor should throw *three* invalid argument exceptions:
    - "empty arguments"
    - "arguments are not strings"
    - "email is not valid"

### 01 - Users Twig Template

- Create a file named `users.html.twig` in the `templates/` directory.
- The file should contain the logic:
```
if there is more users than zero then
    print list title "Members"
    print user list with the format "<name> email is <email>"
else
    print list title "No members"
```

- Include the file `users.html.twig` in the file `index.html.twig` in the content section.

### 02 - Users Array and a new Route

- Add two arrays to the application's dependency injection container.
    - First array named `users` contains:
        - Anne Anderson anne@example.com
        - Ben Barlow ben@example.com
        - Chris Christensen chris@example.com
    - Second array named `users_test` contains:
        - Nothing, it is an empty array.
- In the **existing** URL route `/` add to the argument `users`. 
- Add a **new** URL route named `/users_test/`.
    - This new route renders the `index.html.twig` template and passes the `users_test`.
