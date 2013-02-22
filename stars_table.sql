-- Table: stars

-- DROP TABLE stars;

CREATE TABLE stars
(
  from_star character varying NOT NULL,
  to_star character varying NOT NULL,
  CONSTRAINT "from_to_star_PK" PRIMARY KEY (from_star , to_star ),
  CONSTRAINT "from_star_FK" FOREIGN KEY (from_star)
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT "to_star_FK" FOREIGN KEY (to_star)
      REFERENCES usertry (username) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE stars
  OWNER TO postgres;
