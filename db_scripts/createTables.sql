/*
Author: Hitoshi Oue
Date: April 22, 2020
*/



DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Discussions;
DROP TABLE IF EXISTS Users;
/*DROP TABLE IF EXISTS Cancer_Colrect;
DROP TABLE IF EXISTS Cancer_Digothr;
DROP TABLE IF EXISTS Cancer_Femgen;
DROP TABLE IF EXISTS Cancer_Malegen;
DROP TABLE IF EXISTS Cancer_Respir;
*/


/*USERS TABLE*/
CREATE TABLE Users (Username VARCHAR(20) NOT NULL,
                    FirstName VARCHAR(15) NOT NULL,
                    LastName VARCHAR(15) NOT NULL,
                    Password VARCHAR(500) NOT NULL,
                    Session TEXT NULL,
                    LastLogin TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT PK_Users PRIMARY KEY (Username)
                    );

/* Discussions*/
CREATE TABLE Discussions (PostID INT NOT NULL AUTO_INCREMENT,
                          Title VARCHAR(100) NOT NULL,
                          Body VARCHAR(3000) NOT NULL,
                          Author VARCHAR(20) NOT NULL,
                          CONSTRAINT PK_Discussions PRIMARY KEY (PostID),
                          CONSTRAINT FK_Discussions FOREIGN KEY (Author)
                              REFERENCES Users (Username));

/*Comments*/
CREATE TABLE Comments ( CommentID INT NOT NULL AUTO_INCREMENT,
                        PostID INT NOT NULL,
                        Comment VARCHAR(500) NOT NULL,
                        Author VARCHAR(20) NOT NULL,
                        Stamp DATETIME NOT NULL,
                        CONSTRAINT PK_Comments PRIMARY KEY (CommentID),
                        CONSTRAINT FK_Comments_Author FOREIGN KEY (Author)
                            REFERENCES Users (Username),
                        CONSTRAINT FK_Comments_PostID FOREIGN KEY (PostID)
                            REFERENCES Discussions (PostID));
