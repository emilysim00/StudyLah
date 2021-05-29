
Proposed Level of Achievement: Gemini

<h2>Motivation</h2>
In this covid semester, it is especially hard for students to connect with one another. Freshmans like us are not familiar with the school and hardly have any chance to make friends in school as the majority of the lectures and tutorials are held online. 
While watching lectures, doing tutorials and assignments, you might be stuck with a question or are confused with certain concepts, it is inconvenient having no friends to ask and having to rely on online forums or emails to professors to ask a question. Such methods also have high time delays and might result in an individual feeling lonely and helpless, hence losing the motivation to study. 
Ever felt lazy or had no motivation to study? What if there is a platform for students studying the same modules to connect and discuss?
Thus, we wanted to create a web application, providing the students a platform to connect, expand their social circle and exchange their wisdom, helping one another in their studies, striving for better results. 

Aim
We hope to provide a platform for NUS students (and professors) to connect and forge friendship with each other through exchanging their knowledge in small study sessions. 
The provided platform will allow the user to view the modules others have taken or are currently taking for matching to form small study groups. It also helps users to schedule a date which is available to all for the study session. Additionally, it offers a common shared tasklist which records individual tasks in the group so that not only can you keep track of what you have completed but also keep your friend in check to make sure that everyone is on the same page.

User Stories
1. As an individual who wants to expand their social network within the same industry (or possibly others), I want to be able to find and forge new friendships with people of the same courses, modules or interests easily.
2. As students who want to possibly study in a more efficient manner and exchange notes, I want to be able to form study groups.
3. As a student who has questions or troubles with regards to their modules e.g. assignments, I want to be able to clarify my doubt with people who I am more comfortable with (e.g. some students prefer asking other students instead of professors).
4. As a student who has questions regarding their courses/modules, I want to be able to get information about the modules through experiences from other students who have taken similar modules.
5. As a student who might be busy and have trouble setting a date for meetings, I want to be able to schedule a study date without intervening with my current schedule. 
6. As a student who might be forgetful and bad at keeping track of deadlines, I want to have a tasklist that helps me to sort my assignment deadline and plan out my time. Additionally, having someone to remind of the deadlines when near due.  

Scope of Project
A web application, which includes a front-end user interface and also a back-end database to store students/application data.
How are we different from similar platforms?
Telegram Chat: Telegram chat groups are large in size, users might find it hard to participate or form friendships. StudyLah allows users to form smaller groups and initiate conversation easier.
Trello: Corporate use trello more for tracking their employees’ projects status instead of allowing users to find teammates.

Completed Features [Milestone 1]
Sign Up 
User able to create an account with his/her personal information such as full name, nus email, course information e.g.
Upon creating the account, users will be redirected to the confirmation page where they will be asked to verify their email. To activate his/her account, they have to verify their account by clicking on a verification link sent to the registered nus email account. 
Once verification is done, the user is now a legit user of the platform. The user profile includes the following:
Name
Modules Taken
User’s current course
Residency Status
CCAs
NUS email
Year of study
Log In 
User can log in to access the web application with his/her registered email and password. Once logged in, a session is created and only certain pages can be accessed by logged in users e.g. dashboard. 
Features to be completed [Milestones 2 & 3]
Online Chatting Rooms/Message Box 
Scheduling of meet-ups
Helps to schedule an available date for all study partners to meet up 
Suggests study spots in school 
Suggest when is the peak period
Suggesting/Reminding what is needed to be brought [eg. CLB need student card] 
Shared CheckList
A common checklist shared with all study partners to help keep each other on track
Each person will have their own column to keep track
Allows different filters e.g. sorting of deadlines [from earliest to latest]
Tech Stack 
HTML/CSS (Front-End Development)
PHP
Javascript 
MySQL (Database for Server)
XAMPP (to host services like Apache & MYSQL)
Providing Evidence of creating databases with MySQL and using PHP
We are using PHP and MySQL, to store and manage StudyLah’s data. 
When the user registers for a new account, a verification email containing the user’s unique verification token is sent to their registered email and a new sign up ID is created in the database. 
PHPMailer API is used to send this email. Once verification is done, the user is now a legit user of the platform.
In addition, upon clicking on the “register” button, PHP will query MYSQL to compare data in its database to ensure that there is no duplication of email when registering for an account.
When the user logs in as a registered user, MySQL compares the log-in credentials (user email and password) in order to check for authentication. Once logged in, the user session is created using PHP.

Providing Evidence of creating front-end development for the web application
The user interfaces are designed using technology such as HTML, CSS and Javascript. 
The user-interface is designed to be user-friendly where users are able to navigate around the web application to access the different features without any hassle. CSS is used extensively to improve the user experience e.g. animation and designs. Javascript is used to trigger some of the design (e.g onclick of a button). 

Poster Link
https://drive.google.com/file/d/1rsO_akjU4PBny85V9t_oI7SxMFs8cbk3/view?usp=sharing 

Video Link 
https://drive.google.com/file/d/1nMR0m85Ja2PHnsr4Wdhobj-rbLeyxmH9/view?usp=sharing 

Program Flow


Project Log:

S/N
Task
Date 
Sim Ting Yu Emily (hrs)
Musfirah Wani Bte Abdul Rahim  (hrs)
Remarks 
1
Team meeting and initial planning 
11/05/2021
3
3
Discuss and design on liftoff poster and video
2
Meeting with advisor 
13/05/2021
1
1
Met with advisor to discuss project direction 
3
Mission Control #1 Web Development (HTML/CSS)
15/05/2021
2
2
-


4
Team meeting (Brainstorming)


21/05/2021
3
3
Discussion of the implementation of Database and front end design 
5
Implementation of Database
23/05/2021 - 25/05/2021
6
24
Set up of database
Identify fields required
Set up field types e.g.
6
Front-End development for log in, sign up page 
22/05/2021 - 25/05/2021
24
6
Design the front end pages for some of the features 
7
Combine the front end design with the features 
26/05/2021 - 27/05/2021
6
6
Incorporate the front end design with the database
8
Documentation of milestone 1 
28/05/2021
4
4
Writing the ReadMe file and editing the milestone document







Sim Ting Yu Emily
(hrs) 
Musfirah Wani Bte Abdul Rahim (hrs)
Total Hours
49
49




Appendices 

Index Page
Home page of the web application. Contact Us is included

Figure 1.1 Index Page

Contact Us Page 
Users/Non-users can send their queries to StudyLah by filling up the form 

Figure 1.2 Contact Us page 


Login Page
Log in includes user email and password.

Figure 1.3  Login Page 

Sign up/Register Page
Sign up includes the following fields: Full name, NUS email, password, gender, residency status, course, year of study, current mods and terms and conditions.

Figure 1.4  Register Page 


Figure 1.5 Register - Terms & Conditions 

Thank you page
The page displayed after the user registers for an account.

Figure 1.6 To Verify the email instruction page


Email verification
Below is an example of the email received after registration of account. It includes a unique token.

Figure 1.7 Email received after registration


Verification page
After the user clicks on the link in the email, they are led to the page below. Their account is now legit.

Figure 1.8 After email has been verified


Error pages
For error handling purposes. The error pages done includes handling for:
Existence of duplicated accounts
Any invalid token during verification of account during registration
General (e.g. error that could not be identified)

Figure 1.9 Error Page for existence of duplicate accounts
