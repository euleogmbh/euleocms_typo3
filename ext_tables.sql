CREATE TABLE tx_euleo_domain_model_export (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    filename varchar(250) DEFAULT '0' NOT NULL,
    
    date int(11) DEFAULT '0' NOT NULL,
    ready tinyint(1) DEFAULT '0' NOT NULL,
    content longblob NOT NULL,
    
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
);


CREATE TABLE tx_euleo_config (
    customer varchar( 250 ) NOT NULL,
    usercode varchar( 250 ) NOT NULL,
    token varchar( 250 ) NOT NULL
);

