#
# Table structure for table 'tx_dnexponatsliste_domain_model_listelements'
#
CREATE TABLE tx_dnexponatsliste_domain_model_listelements
(

    uid              int(11)                         NOT NULL auto_increment,
    pid              int(11)             DEFAULT '0' NOT NULL,

    elementtitle     varchar(255)        DEFAULT ''  NOT NULL,
    elementtip       varchar(255)        DEFAULT ''  NOT NULL,
    exceltitle       varchar(255)        DEFAULT ''  NOT NULL,
    exceltip         varchar(255)        DEFAULT ''  NOT NULL,
    beispiel         int(11) unsigned    DEFAULT '0' NOT NULL,
    inputtype        varchar(255)        DEFAULT '0' NOT NULL,
    maxcharacters    varchar(255)        DEFAULT ''  NOT NULL,
    bgcolor          varchar(255)        DEFAULT ''  NOT NULL,
    upload           tinyint(1) unsigned DEFAULT '0' NOT NULL,
    selectfield      varchar(255)        DEFAULT ''  NOT NULL,
    tabs             varchar(255)        DEFAULT ''  NOT NULL,

    tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
    t3ver_id         int(11)             DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
    t3ver_count      int(11)             DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,
    sorting          int(11)             DEFAULT '0' NOT NULL,

    sys_language_uid int(11)             DEFAULT '0' NOT NULL,
    l10n_parent      int(11)             DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_exponate'
#
CREATE TABLE tx_dnexponatsliste_domain_model_exponate
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    createdby        varchar(255)     DEFAULT ''  NOT NULL,
    createdat        int(11)          DEFAULT '0' NOT NULL,
    editedby         varchar(255)     DEFAULT ''  NOT NULL,
    editedat         int(11)          DEFAULT '0' NOT NULL,
    exponatsnr       varchar(255)     DEFAULT ''  NOT NULL,
    ansprechpartner  varchar(255)     DEFAULT ''  NOT NULL,
    institut         varchar(255)     DEFAULT ''  NOT NULL,
    user_entrys      int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,
    sorting          int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_userentrys'
#
CREATE TABLE tx_dnexponatsliste_domain_model_userentrys
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    exponate         int(11) unsigned DEFAULT '0' NOT NULL,

    listelement      varchar(255)     DEFAULT ''  NOT NULL,
    listentry        text                         NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_spaltensperren'
#
CREATE TABLE tx_dnexponatsliste_domain_model_spaltensperren
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    gesperrteelemte  varchar(255)     DEFAULT ''  NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_emailreceiver'
#
CREATE TABLE tx_dnexponatsliste_domain_model_emailreceiver
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    mailadress       varchar(255)     DEFAULT ''  NOT NULL,
    receivername     varchar(255)     DEFAULT ''  NOT NULL,
    userid           int(11)          DEFAULT '0' NOT NULL,
    maillanguage     varchar(255)     DEFAULT ''  NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'sys_file_reference'
#
CREATE TABLE sys_file_reference
(

    listelements int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_userentrys'
#
CREATE TABLE tx_dnexponatsliste_domain_model_userentrys
(

    exponate int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users
(
    tx_extendfeuserspages_AllowedFePages int(11) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'fe_users_tx_extendfeuserspages_AllowedFePages_mm'
#
CREATE TABLE fe_users_tx_extendfeuserspages_AllowedFePages_mm
(
    uid_local   int(11)     DEFAULT '0' NOT NULL,
    uid_foreign int(11)     DEFAULT '0' NOT NULL,
    tablenames  varchar(30) DEFAULT ''  NOT NULL,
    sorting     int(11)     DEFAULT '0' NOT NULL,
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_tabs'
#
CREATE TABLE tx_dnexponatsliste_domain_model_tabs
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    tabs             varchar(255)     DEFAULT ''  NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,
    sorting          int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_dnexponatsliste_domain_model_deadline'
#
CREATE TABLE tx_dnexponatsliste_domain_model_deadline
(

    uid              int(11)                      NOT NULL auto_increment,
    pid              int(11)          DEFAULT '0' NOT NULL,

    listelement      varchar(255)     DEFAULT '0' NOT NULL,
    deadline         int(11)          DEFAULT '0' NOT NULL,

    tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
    crdate           int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,

    t3ver_oid        int(11)          DEFAULT '0' NOT NULL,
    t3ver_id         int(11)          DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)          DEFAULT '0' NOT NULL,
    t3ver_label      varchar(255)     DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)       DEFAULT '0' NOT NULL,
    t3ver_stage      int(11)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)          DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)          DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)          DEFAULT '0' NOT NULL,
    sorting          int(11)          DEFAULT '0' NOT NULL,

    sys_language_uid int(11)          DEFAULT '0' NOT NULL,
    l10n_parent      int(11)          DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid, t3ver_wsid),
    KEY language (l10n_parent, sys_language_uid)

);