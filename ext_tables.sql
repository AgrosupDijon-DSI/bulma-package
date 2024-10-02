#
# Table structure for table 'tx_bulmapackage_settings'
#
CREATE TABLE tx_bulmapackage_settings
(
    title_seo                          varchar(255) DEFAULT '' NOT NULL,
    wsd_name                           varchar(255) DEFAULT '' NOT NULL,
    wsd_alternate_name                 varchar(255) DEFAULT '' NOT NULL,
    logo_main                          int(11) unsigned DEFAULT '0' NOT NULL,
    logos_partners                     int(11) unsigned DEFAULT '0' NOT NULL,
    favicon                            int(11) unsigned DEFAULT '0' NOT NULL,
    code_analytics                     varchar(255) DEFAULT '' NOT NULL,
    address_title                      varchar(255) DEFAULT '' NOT NULL,
    address                            tinytext,
    zip                                varchar(20)  DEFAULT '' NOT NULL,
    city                               varchar(255) DEFAULT '' NOT NULL,
    country                            varchar(128) DEFAULT '' NOT NULL,
    phone                              varchar(30)  DEFAULT '' NOT NULL,
    fax                                varchar(30)  DEFAULT '' NOT NULL,
    email                              varchar(255) DEFAULT '' NOT NULL,
    latitude                           varchar(255) DEFAULT '' NOT NULL,
    longitude                          varchar(255) DEFAULT '' NOT NULL,
    tx_bulmapackage_settings_link_item int(11) unsigned DEFAULT '0',
    menu_layout                        varchar(30)  DEFAULT '' NOT NULL,
    sharing_services                   text,
);

#
# Table structure for table 'tx_bulmapackage_custom_color'
#
CREATE TABLE tx_bulmapackage_custom_color
(
    label         varchar(255) DEFAULT '' NOT NULL,
    var_primary   varchar(255) DEFAULT '' NOT NULL,
    var_link      varchar(255) DEFAULT '' NOT NULL,
    var_success   varchar(255) DEFAULT '' NOT NULL,
    var_info      varchar(255) DEFAULT '' NOT NULL,
    var_warning   varchar(255) DEFAULT '' NOT NULL,
    var_danger    varchar(255) DEFAULT '' NOT NULL,
    var_text_dark smallint unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_bulmapackage_meta_tags'
#
CREATE TABLE tx_bulmapackage_meta_tags
(
    name    varchar(255) DEFAULT '' NOT NULL,
    content varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_bulmapackage_settings_link_item'
#
CREATE TABLE tx_bulmapackage_settings_link_item
(
    tx_bulmapackage_settings int(11) unsigned DEFAULT '0',
    label                    varchar(255)  DEFAULT '' NOT NULL,
    link                     varchar(1024) DEFAULT '' NOT NULL,
    icon                     varchar(255)  DEFAULT '' NOT NULL,
    icon_file                int(11) unsigned DEFAULT '0',
    force_label              tinyint(4) unsigned DEFAULT '0' NOT NULL,
    standalone               tinyint(4) unsigned DEFAULT '0' NOT NULL,
    icon_custom              tinyint(4) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content
(
    header_position                        varchar(10)  DEFAULT ''        NOT NULL,
    background_color_class                 varchar(255) DEFAULT ''        NOT NULL,
    background_frame                       varchar(255) DEFAULT 'limited' NOT NULL,
    file_folder                            text,
    readmore_label                         varchar(255) DEFAULT ''        NOT NULL,
    message_class                          varchar(60)  DEFAULT 'default' NOT NULL,
    gallery_size                           varchar(10)  DEFAULT ''        NOT NULL,
    ignore_nav_hide                        tinyint(4) DEFAULT '0' NOT NULL,
    max_items                              varchar(255) DEFAULT ''        NOT NULL,

    tx_bulmapackage_card_group_item        int(11) unsigned DEFAULT '0',
    tx_bulmapackage_thumbnail_group_item   int(11) unsigned DEFAULT '0',
    tx_bulmapackage_icon_group_item        int(11) unsigned DEFAULT '0',

    tx_bulmapackage_tab_item_parent        int(11) DEFAULT '0' NOT NULL,
    tx_bulmapackage_tab_item               int(11) unsigned DEFAULT '0' NOT NULL,

    tx_bulmapackage_accordion_item_parent  int(11) DEFAULT '0' NOT NULL,
    tx_bulmapackage_accordion_item         int(11) unsigned DEFAULT '0' NOT NULL,
    tx_bulmapackage_accordion_item_active  int(11) unsigned DEFAULT '0' NOT NULL,

    tx_bulmapackage_carousel_item          int(11) unsigned DEFAULT '0',

    tx_bulmapackage_sharing_services       text,
    tx_bulmapackage_sharing_services_label varchar(255) DEFAULT NULL,

    tx_mask_content_role                   varchar(255) DEFAULT ''        NOT NULL
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages
(
    thumbnail                 int(11) unsigned DEFAULT '0',
    exclude_slug_for_subpages tinyint(1) DEFAULT '0' NOT NULL,
    hide_breadcrumb           tinyint(1) DEFAULT '0' NOT NULL,
);

#
# Table structure for table 'tx_bulmapackage_accordion_item'
#
CREATE TABLE tx_bulmapackage_accordion_item
(
    tt_content int(11) DEFAULT '0' NOT NULL,
    record     int(11) unsigned DEFAULT '0' NOT NULL,
    title      tinytext
);

#
# Table structure for table 'tx_bulmapackage_tab_item'
#
CREATE TABLE tx_bulmapackage_tab_item
(
    tt_content int(11) DEFAULT '0' NOT NULL,
    record     int(11) unsigned DEFAULT '0' NOT NULL,
    title      varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_bulmapackage_card_group_item'
#
CREATE TABLE tx_bulmapackage_card_group_item
(
    tt_content int(11) unsigned DEFAULT '0',
    header     varchar(255)  DEFAULT '' NOT NULL,
    subheader  varchar(255)  DEFAULT '' NOT NULL,
    media      int(11) DEFAULT '0' NOT NULL,
    bodytext   text,
    link       varchar(1024) DEFAULT '' NOT NULL,
    link_title varchar(255)  DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_bulmapackage_thumbnail_group_item'
#
CREATE TABLE tx_bulmapackage_thumbnail_group_item
(
    tt_content int(11) unsigned DEFAULT '0',
    header     varchar(255)  DEFAULT '' NOT NULL,
    subheader  varchar(255)  DEFAULT '' NOT NULL,
    media      int(11) DEFAULT '0' NOT NULL,
    link       varchar(1024) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_bulmapackage_carousel_item'
#
CREATE TABLE tx_bulmapackage_carousel_item
(
    tt_content       int(11) unsigned DEFAULT '0',
    item_type        varchar(255)  DEFAULT ''  NOT NULL,
    header           varchar(255)  DEFAULT ''  NOT NULL,
    header_layout    varchar(30)   DEFAULT '0' NOT NULL,
    text_color       varchar(255)  DEFAULT ''  NOT NULL,
    subheader        varchar(255)  DEFAULT ''  NOT NULL,
    button_text      varchar(255)  DEFAULT ''  NOT NULL,
    button_class     varchar(255)  DEFAULT ''  NOT NULL,
    link             varchar(1024) DEFAULT ''  NOT NULL,
    background_color varchar(255)  DEFAULT ''  NOT NULL,
    image            int(11) unsigned DEFAULT '0'
);

#
# Table structure for table 'tx_bulmapackage_icon_group_item'
#
CREATE TABLE tx_bulmapackage_icon_group_item
(
    tt_content int(11) unsigned DEFAULT '0',
    bodytext   mediumtext,
    link       varchar(1024) DEFAULT '' NOT NULL,
    icon       varchar(255)  DEFAULT '' NOT NULL,
    icon_set   varchar(255)  DEFAULT '' NOT NULL,
    icon_file  int(11) unsigned DEFAULT '0',
    icon_size  varchar(255)  DEFAULT '' NOT NULL,
    icon_color varchar(255)  DEFAULT '' NOT NULL
);
