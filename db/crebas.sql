/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     19.01.2021 14:00:46                          */
/*==============================================================*/


drop index AUTHOR_NAME_IDX on AT_NEWS;

drop index DATE_IDX on AT_NEWS;

drop index TITLE_IDX on AT_NEWS;

drop table if exists AT_NEWS;

/*==============================================================*/
/* Table: AT_NEWS                                               */
/*==============================================================*/
create table AT_NEWS
(
   ID_NEWS		INT(10) NOT NULL AUTO_INCREMENT,
   TITLE                varchar(50) not null,
   DATE                 datetime not null,
   SHORT_CONTENT        varchar(255) not null,
   FULL_CONTENT         longtext not null,
   AUTHOR_NAME          varchar(255) not null,
   PREVIEW              varchar(255) not null,
   TYPE                 varchar(50)  comment,
   primary key (ID_NEWS)
);

/*==============================================================*/
/* Index: TITLE_IDX                                             */
/*==============================================================*/
create unique index TITLE_IDX on AT_NEWS
(
   TITLE
);

/*==============================================================*/
/* Index: DATE_IDX                                              */
/*==============================================================*/
create index DATE_IDX on AT_NEWS
(
   DATE
);

/*==============================================================*/
/* Index: AUTHOR_NAME_IDX                                       */
/*==============================================================*/
create index AUTHOR_NAME_IDX on AT_NEWS
(
   AUTHOR_NAME
);

