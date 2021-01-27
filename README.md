# Jul-Projekt

Coding assignment in web development at Yrgo. </br>

Create a clone of the site Hacker news.



## Features that needs to be included

- As a user I should be able to create an account.

- As a user I should be able to login.

- As a user I should be able to logout.

- As a user I should be able to edit my account email, password and biography.

- As a user I should be able to upload a profile avatar image.

- As a user I should be able to create new posts with title, link and description.

- As a user I should be able to edit my posts.

- As a user I should be able to delete my posts.

- As a user I'm able to view most upvoted posts.

- As a user I'm able to view new posts.

- As a user I should be able to upvote posts.

- As a user I should be able to remove upvote from posts.

- As a user I'm able to comment on a post.

- As a user I'm able to edit my comments.

## Extra features
Added by [Carolina Hagman](https://github.com/carolinahagman)

- As a user I'm able to upvote and remove upvote on comments.

- As a user I'm able to delete my account along with all posts, upvotes and comments.

[link to pull request](https://github.com/Fvrom/Hacker-News/pull/2)

## Checklist

- [x] Log in
- [x] Log out
- [x] Sign up
- [x] Dummy posts, ranked latest
- [x] Create posts, Delete posts, Edit posts
- [x] Profile page, able to see posts user has posted
- [x] Upload profile photo
- [x] Edit profile
- [x] Comments, edit, delete
- [x] Upvotes

#### To keep working on
- [ ] Add unique id for avatar images
- [ ] Put a max-width.
- [ ] Accessibility 
- [ ] PDO needs fixing with PARAM
- [ ] add fetch() to like and edit buttons


- [ ] Delete user
- [ ] Reset password with email.

## Installation 
1. Clone the repository to your computer.

2. Go to the repository folder in your terminal. 

3. Start a local server in the command line 

```
php -S localhost:8000
```

4. open up localhost:8000/index.php in your browser


## Testers:
1. [Linn Josefsson](https://github.com/LinnJosefsson)

2. [Réka Madarász](https://github.com/mreka91)


## Feedback: - Joakim Sjögren

- index.php: 4 - Causes a warning when you are not logged in. Same with trending.php: 5.

- index.php - I like the use of shorthanded if statements, makes it easy to read. 

- index.php: 22 - Causes a warning. because the file is trying to pass in an undefined variable as an argument "$allPosts".

- comments.php: 7 - Unused variable.

- login.php - I like the feedback given to the user in forms of error messages.

- login.php - I would add an if statement to check if a user is logged in. Currently you can like a post even if you are not logged in.

- commentstore.php: 18 - I like the idea of storing a query in a variable.

- The css files are well structured and easy to understand.

- submit.php: 13 - Instead of telling the user to log in, i would send them directly to the login page.

- I like that there's a lot of comments through out the project explaining what you are doing.
- Great job!
