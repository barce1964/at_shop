/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     14.02.2021 20:26:09                          */
/*==============================================================*/


alter table AT_SHOP_PROD 
   drop foreign key FK_AT_SHOP__REFERENCE_AT_SHOP_;

drop index EMAIL_USER_IDX on AT_ADM_USERS;

drop index NAME_USER_IDX on AT_ADM_USERS;

drop table if exists AT_ADM_USERS;

drop index AUTHOR_NAME_IDX on AT_NEWS;

drop index DATE_IDX on AT_NEWS;

drop index TITLE_IDX on AT_NEWS;

drop table if exists AT_NEWS;

drop index SORT_ORDER_IDX on AT_SHOP_CAT;

drop index NAME_CAT_IDX on AT_SHOP_CAT;

drop table if exists AT_SHOP_CAT;

drop index BRAND_PROD_IDX on AT_SHOP_PROD;

drop index CODE_PROD_IDX on AT_SHOP_PROD;

drop index NAME_PROD_IDX on AT_SHOP_PROD;


alter table AT_SHOP_PROD 
   drop foreign key FK_AT_SHOP__REFERENCE_AT_SHOP_;

drop table if exists AT_SHOP_PROD;

/*==============================================================*/
/* Table: AT_ADM_USERS                                          */
/*==============================================================*/
create table AT_ADM_USERS
(
   ID_USER              int not null AUTO_INCREMENT,
   NAME_USER            varchar(20) not null,
   EMAIL_USER           varchar(60) not null,
   PWD_USER             varchar(255) not null,
   USER_CIF             varchar(50) not null,
   USER_IV              varchar(100) not null,
   primary key (ID_USER)
);

/*==============================================================*/
/* Index: NAME_USER_IDX                                         */
/*==============================================================*/
create unique index NAME_USER_IDX on AT_ADM_USERS
(
   NAME_USER
);

/*==============================================================*/
/* Index: EMAIL_USER_IDX                                        */
/*==============================================================*/
create unique index EMAIL_USER_IDX on AT_ADM_USERS
(
   EMAIL_USER
);

/*==============================================================*/
/* Table: AT_NEWS                                               */
/*==============================================================*/
create table AT_NEWS
(
   ID_NEWS              int not null AUTO_INCREMENT,
   TITLE                varchar(50) not null,
   DATE                 datetime not null,
   SHORT_CONTENT        varchar(255) not null,
   FULL_CONTENT         longtext not null,
   AUTHOR_NAME          varchar(255) not null,
   PREVIEW              varchar(255) not null,
   TYPE                 varchar(50),
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

/*==============================================================*/
/* Table: AT_SHOP_CAT                                           */
/*==============================================================*/
create table AT_SHOP_CAT
(
   ID_CAT               int not null AUTO_INCREMENT,
   NAME_CAT             varchar(255) not null,
   SORT_ORDER           int not null,
   STATUS_CAT           bool not null default 1,
   primary key (ID_CAT)
);

/*==============================================================*/
/* Index: NAME_CAT_IDX                                          */
/*==============================================================*/
create unique index NAME_CAT_IDX on AT_SHOP_CAT
(
   NAME_CAT
);

/*==============================================================*/
/* Index: SORT_ORDER_IDX                                        */
/*==============================================================*/
create index SORT_ORDER_IDX on AT_SHOP_CAT
(
   SORT_ORDER
);

/*==============================================================*/
/* Table: AT_SHOP_PROD                                          */
/*==============================================================*/
create table AT_SHOP_PROD
(
   ID_PROD              int not null AUTO_INCREMENT,
   ID_CAT               int not null,
   NAME_PROD            varchar(255) not null,
   CODE_PROD            int not null,
   PRICE_PROD           float not null,
   AVAILABILITY         bool not null default 1,
   BRAND_PROD           varchar(255) not null,
   IMAGE_PROD           varchar(255) not null,
   DESCR_PROD           text not null,
   IS_NEW               bool not null default 0,
   IS_REC               bool not null default 0,
   STATUS_PROD          bool not null default 1,
   primary key (ID_PROD)
);

/*==============================================================*/
/* Index: NAME_PROD_IDX                                         */
/*==============================================================*/
create index NAME_PROD_IDX on AT_SHOP_PROD
(
   NAME_PROD
);

/*==============================================================*/
/* Index: CODE_PROD_IDX                                         */
/*==============================================================*/
create index CODE_PROD_IDX on AT_SHOP_PROD
(
   CODE_PROD
);

/*==============================================================*/
/* Index: BRAND_PROD_IDX                                        */
/*==============================================================*/
create index BRAND_PROD_IDX on AT_SHOP_PROD
(
   BRAND_PROD
);

alter table AT_SHOP_PROD add constraint FK_AT_SHOP__REFERENCE_AT_SHOP_ foreign key (ID_CAT)
      references AT_SHOP_CAT (ID_CAT) on delete restrict on update restrict;

