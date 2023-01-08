# Password-Manager

A password manager built with html, css/bootstrap, js/ajax, MySql, and PHP. The password manager has a fully integrated login/logout system that is secure, storing login passwords in a hashed format in the MySql database. The user account details are end to end encrypted, where the encryption key for the data is the unhashed version of the password, this encryption key (unhashed password) is stored temporarly in the session variables, and dystroyed upon log out - creating a zero knowledge system.
