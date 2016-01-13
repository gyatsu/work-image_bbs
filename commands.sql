#データベース作成
create database image_post;
#データベース選択
use image_post;
#作業ユーザの設定/該当データベースとユーザ名、パスワードを設定
grant all on image_post.* to testuser1@localhost identified by 'test';

#テーブル作成
create table posts(
id int primary key auto_increment,
name varchar(32) not null ,
title varchar(32) not null ,
created_at datetime not null
);

#作成したテーブルの確認
show tables;
#テーブルの構造を確認
desc posts;
