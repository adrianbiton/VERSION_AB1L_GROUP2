-- Table: comments

-- DROP TABLE comments;

CREATE TABLE comments
(
  comment character varying NOT NULL,
  "from" character varying NOT NULL,
  "to" character varying NOT NULL,
  CONSTRAINT "from_to_PK" PRIMARY KEY ("from" , "to" ),
  CONSTRAINT "from_FK" FOREIGN KEY ("from")
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT "to_FK" FOREIGN KEY ("to")
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE comments
  OWNER TO postgres;
