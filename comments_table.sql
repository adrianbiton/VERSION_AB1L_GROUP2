-- Table: comments

-- DROP TABLE comments;

CREATE TABLE comments
(
  for_who character varying NOT NULL,
  from_who character varying NOT NULL,
  comment character varying NOT NULL,
  "time" timestamp with time zone NOT NULL,
  CONSTRAINT "from_to_time_comment_PK" PRIMARY KEY (for_who , from_who , "time" , comment ),
  CONSTRAINT "for_who_FK" FOREIGN KEY (for_who)
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT "from_who_FK" FOREIGN KEY (from_who)
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE comments
  OWNER TO postgres;
