-- Table: blogs

-- DROP TABLE blogs;

CREATE TABLE blogs
(
  blog_id integer NOT NULL,
  date_published timestamp with time zone,
  image character varying(30),
  title character varying,
  caption character varying(40),
  owner character varying(40) NOT NULL,
  CONSTRAINT "blog_id_PK" PRIMARY KEY (blog_id ),
  CONSTRAINT "blogs_user_FK" FOREIGN KEY (owner)
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE blogs
  OWNER TO postgres;
