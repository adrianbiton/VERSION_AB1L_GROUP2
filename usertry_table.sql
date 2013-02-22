-- Table: usertry

-- DROP TABLE usertry;

CREATE TABLE usertry
(
  username character varying(20) NOT NULL,
  pword character varying(20),
  fname character varying(20),
  mname character varying(20),
  lname character varying(20),
  bday character varying(20),
  email character varying(50),
  gender character varying(10),
  CONSTRAINT username PRIMARY KEY (username )
)
WITH (
  OIDS=FALSE
);
ALTER TABLE usertry
  OWNER TO postgres;
