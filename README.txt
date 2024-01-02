1. In order to make the passwords have better security, I would use a hash function to convert the given password into a 
specific hash, and then when that password is needed, revert that hash function to get the password back. The security of the 
password will depend on the strength of the hash function. I could also implement some sort of key-value pair together with hashing
where the value is the hashed password, and a unique key is generated that is paired with the hashed password. 
2. A good way to deal with users forgetting their passwords is through the use of a password manager. A password manager will
use one of the ways described above to store an encrypted version of your password, and then it can be accessed if forgotton. 
A bad way of dealing with forgotton passwords is recovery through the use of recovery questions. This way is far less secure 
compared to a password manager because it is easier for a malicious user to guess the answer to a password recovery question 
than it is for them to decrypt a password manager. 
3. One of the most important things to remember when implementing a remember me function is how long the server will remember that
specific user, as it is important to have a time limit so that a user's information is not indefinitely stored on the web server. 
Another thing to consider is the security risks you are bringing in with such functionality. IF someone's computer is stolen, then 
that person will have access to everything applciation that rememebrs that specific user, which can lead to larger security threats. 
4. Some best practices for cookies is to always make sure that your cookies have an expiration date, as you do not want to keep 
user data for an undefined amount of time, and you want to be selective on the types of information you store within your cookies. 
5. https stands for Hypertext Transfer Protocol Secure which is an extension of HTTP. https is used to have more secure transfer 
of information between web pages and web servers. Some important features of https include data integrity and data encryption. 