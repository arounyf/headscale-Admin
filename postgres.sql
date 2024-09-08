/*
 Navicat Premium Data Transfer

 Source Server         : postgres
 Source Server Type    : PostgreSQL
 Source Server Version : 140013
 Source Host           : 110.42.36.218:5432
 Source Catalog        : test
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 140013
 File Encoding         : 65001

 Date: 08/09/2024 19:13:49
*/


-- ----------------------------
-- Type structure for tablestruct
-- ----------------------------
DROP TYPE IF EXISTS "public"."tablestruct";
CREATE TYPE "public"."tablestruct" AS (
  "fields_key_name" varchar(100) COLLATE "pg_catalog"."default",
  "fields_name" varchar(200) COLLATE "pg_catalog"."default",
  "fields_type" varchar(20) COLLATE "pg_catalog"."default",
  "fields_length" int8,
  "fields_not_null" varchar(10) COLLATE "pg_catalog"."default",
  "fields_default" varchar(500) COLLATE "pg_catalog"."default",
  "fields_comment" varchar(1000) COLLATE "pg_catalog"."default"
);
ALTER TYPE "public"."tablestruct" OWNER TO "postgres";

-- ----------------------------
-- Sequence structure for acls_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."acls_id_seq";
CREATE SEQUENCE "public"."acls_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for api_keys_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."api_keys_id_seq";
CREATE SEQUENCE "public"."api_keys_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for logs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."logs_id_seq";
CREATE SEQUENCE "public"."logs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for machines_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."machines_id_seq";
CREATE SEQUENCE "public"."machines_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pre_auth_key_acl_tags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pre_auth_key_acl_tags_id_seq";
CREATE SEQUENCE "public"."pre_auth_key_acl_tags_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pre_auth_keys_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pre_auth_keys_id_seq";
CREATE SEQUENCE "public"."pre_auth_keys_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for routes_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."routes_id_seq";
CREATE SEQUENCE "public"."routes_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for acls
-- ----------------------------
DROP TABLE IF EXISTS "public"."acls";
CREATE TABLE "public"."acls" (
  "id" int4 NOT NULL DEFAULT nextval('acls_id_seq'::regclass),
  "acl" text COLLATE "pg_catalog"."default",
  "user_id" int4
)
;

-- ----------------------------
-- Records of acls
-- ----------------------------

-- ----------------------------
-- Table structure for api_keys
-- ----------------------------
DROP TABLE IF EXISTS "public"."api_keys";
CREATE TABLE "public"."api_keys" (
  "id" int8 NOT NULL DEFAULT nextval('api_keys_id_seq'::regclass),
  "prefix" text COLLATE "pg_catalog"."default",
  "hash" bytea,
  "created_at" timestamptz(6),
  "expiration" timestamptz(6),
  "last_seen" timestamptz(6)
)
;

-- ----------------------------
-- Records of api_keys
-- ----------------------------

-- ----------------------------
-- Table structure for apis
-- ----------------------------
DROP TABLE IF EXISTS "public"."apis";
CREATE TABLE "public"."apis" (
  "id" int4 NOT NULL,
  "title" text COLLATE "pg_catalog"."default",
  "href" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of apis
-- ----------------------------
INSERT INTO "public"."apis" VALUES (10, '登出', 'Api/logout');
INSERT INTO "public"."apis" VALUES (20, '改密', 'Api/password');
INSERT INTO "public"."apis" VALUES (30, '获取用户', 'Api/getUsers');
INSERT INTO "public"."apis" VALUES (40, '删除用户', 'Api/delUser');
INSERT INTO "public"."apis" VALUES (50, '更改所有者', 'Api/new_owner');
INSERT INTO "public"."apis" VALUES (60, '启用用户', 'Api/user_enable');
INSERT INTO "public"."apis" VALUES (70, '修改到期时间', 'Api/re_expire');
INSERT INTO "public"."apis" VALUES (80, '控制台初始化', 'Api/initData');
INSERT INTO "public"."apis" VALUES (90, '获取节点', 'Api/getMachine');
INSERT INTO "public"."apis" VALUES (100, '重命名', 'Api/rename');
INSERT INTO "public"."apis" VALUES (110, '添加节点', 'Api/addNode');
INSERT INTO "public"."apis" VALUES (120, '删除节点', 'Api/delNode');
INSERT INTO "public"."apis" VALUES (130, '获取路由', 'Api/getRoute');
INSERT INTO "public"."apis" VALUES (140, '启用路由', 'Api/route_enable');
INSERT INTO "public"."apis" VALUES (150, '禁用路由', 'Api/route_disable');
INSERT INTO "public"."apis" VALUES (160, '删除路由', 'Api/delRoute');
INSERT INTO "public"."apis" VALUES (170, '获取acl', 'Api/getAcls');
INSERT INTO "public"."apis" VALUES (180, '修改acl', 'Api/re_acl');
INSERT INTO "public"."apis" VALUES (190, '重写acl', 'Api/rewrite_acl');
INSERT INTO "public"."apis" VALUES (200, '读取acl', 'Api/read_acl');
INSERT INTO "public"."apis" VALUES (210, '重载headscale配置', 'Api/reload');
INSERT INTO "public"."apis" VALUES (220, '获取日志', 'Api/getLogs');
INSERT INTO "public"."apis" VALUES (230, '获取密钥', 'Api/getPreAuthKey');
INSERT INTO "public"."apis" VALUES (250, '删除key', 'Api/delKey');
INSERT INTO "public"."apis" VALUES (240, '新增key', 'Api/addKey');

-- ----------------------------
-- Table structure for kvs
-- ----------------------------
DROP TABLE IF EXISTS "public"."kvs";
CREATE TABLE "public"."kvs" (
  "key" text COLLATE "pg_catalog"."default",
  "value" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of kvs
-- ----------------------------
INSERT INTO "public"."kvs" VALUES ('db_version', '1');

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS "public"."logs";
CREATE TABLE "public"."logs" (
  "id" int4 NOT NULL DEFAULT nextval('logs_id_seq'::regclass),
  "user_id" int4,
  "content" varchar(255) COLLATE "pg_catalog"."default",
  "create_time" timestamp(6)
)
;

-- ----------------------------
-- Records of logs
-- ----------------------------

-- ----------------------------
-- Table structure for machines
-- ----------------------------
DROP TABLE IF EXISTS "public"."machines";
CREATE TABLE "public"."machines" (
  "id" int8 NOT NULL DEFAULT nextval('machines_id_seq'::regclass),
  "machine_key" varchar(64) COLLATE "pg_catalog"."default",
  "node_key" text COLLATE "pg_catalog"."default",
  "disco_key" text COLLATE "pg_catalog"."default",
  "ip_addresses" text COLLATE "pg_catalog"."default",
  "hostname" text COLLATE "pg_catalog"."default",
  "given_name" varchar(63) COLLATE "pg_catalog"."default",
  "user_id" int8,
  "register_method" text COLLATE "pg_catalog"."default",
  "forced_tags" text COLLATE "pg_catalog"."default",
  "auth_key_id" int8,
  "last_seen" timestamptz(6),
  "last_successful_update" timestamptz(6),
  "expiry" timestamptz(6),
  "host_info" text COLLATE "pg_catalog"."default",
  "endpoints" text COLLATE "pg_catalog"."default",
  "created_at" timestamptz(6),
  "updated_at" timestamptz(6),
  "deleted_at" timestamptz(6)
)
;

-- ----------------------------
-- Records of machines
-- ----------------------------

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS "public"."menus";
CREATE TABLE "public"."menus" (
  "id" int4 NOT NULL,
  "title" text COLLATE "pg_catalog"."default",
  "href" text COLLATE "pg_catalog"."default",
  "show" bool
)
;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO "public"."menus" VALUES (10, '用户', 'Admin/user', 't');
INSERT INTO "public"."menus" VALUES (20, '节点', 'Admin/node', 't');
INSERT INTO "public"."menus" VALUES (30, '路由', 'Admin/route', 't');
INSERT INTO "public"."menus" VALUES (40, '指令', 'Admin/deploy', 't');
INSERT INTO "public"."menus" VALUES (50, '文档', 'Admin/help', 't');
INSERT INTO "public"."menus" VALUES (60, 'ACL', 'Admin/acl', 't');
INSERT INTO "public"."menus" VALUES (80, '个人中心', 'Admin/info', 'f');
INSERT INTO "public"."menus" VALUES (90, 'Index', 'Admin/index', 'f');
INSERT INTO "public"."menus" VALUES (100, '控制台', 'Admin/console', 'f');
INSERT INTO "public"."menus" VALUES (110, '修改密码', 'Admin/password', 'f');
INSERT INTO "public"."menus" VALUES (120, '日志', 'Admin/log', 't');
INSERT INTO "public"."menus" VALUES (70, '密钥', 'Admin/preauthkey', 't');

-- ----------------------------
-- Table structure for pre_auth_key_acl_tags
-- ----------------------------
DROP TABLE IF EXISTS "public"."pre_auth_key_acl_tags";
CREATE TABLE "public"."pre_auth_key_acl_tags" (
  "id" int8 NOT NULL DEFAULT nextval('pre_auth_key_acl_tags_id_seq'::regclass),
  "pre_auth_key_id" int8,
  "tag" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of pre_auth_key_acl_tags
-- ----------------------------

-- ----------------------------
-- Table structure for pre_auth_keys
-- ----------------------------
DROP TABLE IF EXISTS "public"."pre_auth_keys";
CREATE TABLE "public"."pre_auth_keys" (
  "id" int8 NOT NULL DEFAULT nextval('pre_auth_keys_id_seq'::regclass),
  "key" text COLLATE "pg_catalog"."default",
  "user_id" int8,
  "reusable" bool,
  "ephemeral" bool DEFAULT false,
  "used" bool DEFAULT false,
  "created_at" timestamptz(6),
  "expiration" timestamptz(6)
)
;

-- ----------------------------
-- Records of pre_auth_keys
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS "public"."roles";
CREATE TABLE "public"."roles" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "hrefs" varchar(255) COLLATE "pg_catalog"."default",
  "type" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO "public"."roles" VALUES (1, 'manager', '10,20,30,60,40,50,70,80,90,100,110,120', 'menus');
INSERT INTO "public"."roles" VALUES (4, 'manager', '10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,160,170,180,190,200,210,220,230,240,250', 'api');
INSERT INTO "public"."roles" VALUES (2, 'user', '20,30,40,50,70,80,90,100,110,120', 'menus');
INSERT INTO "public"."roles" VALUES (3, 'user', '10,20,80,90,100,110,120,130,140,150,160,220,230,240,250', 'api');

-- ----------------------------
-- Table structure for routes
-- ----------------------------
DROP TABLE IF EXISTS "public"."routes";
CREATE TABLE "public"."routes" (
  "id" int8 NOT NULL DEFAULT nextval('routes_id_seq'::regclass),
  "created_at" timestamptz(6),
  "updated_at" timestamptz(6),
  "deleted_at" timestamptz(6),
  "machine_id" int8,
  "prefix" text COLLATE "pg_catalog"."default",
  "advertised" bool,
  "enabled" bool,
  "is_primary" bool
)
;

-- ----------------------------
-- Records of routes
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "created_at" timestamptz(6),
  "updated_at" timestamptz(6),
  "deleted_at" timestamptz(6),
  "name" text COLLATE "pg_catalog"."default",
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "expire" timestamptz(6),
  "cellphone" varchar(255) COLLATE "pg_catalog"."default",
  "role" varchar(255) COLLATE "pg_catalog"."default",
  "enable" bool
)
;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Function structure for pgsql_type
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."pgsql_type"("a_type" varchar);
CREATE OR REPLACE FUNCTION "public"."pgsql_type"("a_type" varchar)
  RETURNS "pg_catalog"."varchar" AS $BODY$
DECLARE
     v_type varchar;
BEGIN
     IF a_type='int8' THEN
          v_type:='bigint';
     ELSIF a_type='int4' THEN
          v_type:='integer';
     ELSIF a_type='int2' THEN
          v_type:='smallint';
     ELSIF a_type='bpchar' THEN
          v_type:='char';
     ELSE
          v_type:=a_type;
     END IF;
     RETURN v_type;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for table_msg
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."table_msg"("a_table_name" varchar);
CREATE OR REPLACE FUNCTION "public"."table_msg"("a_table_name" varchar)
  RETURNS SETOF "public"."tablestruct" AS $BODY$
DECLARE
    v_ret tablestruct;
BEGIN
    FOR v_ret IN SELECT * FROM table_msg('public',a_table_name) LOOP
        RETURN NEXT v_ret;
    END LOOP;
    RETURN;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
COMMENT ON FUNCTION "public"."table_msg"("a_table_name" varchar) IS '获得表信息';

-- ----------------------------
-- Function structure for table_msg
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."table_msg"("a_schema_name" varchar, "a_table_name" varchar);
CREATE OR REPLACE FUNCTION "public"."table_msg"("a_schema_name" varchar, "a_table_name" varchar)
  RETURNS SETOF "public"."tablestruct" AS $BODY$
DECLARE
     v_ret tablestruct;
     v_oid oid;
     v_sql varchar;
     v_rec RECORD;
     v_key varchar;
BEGIN
     SELECT
           pg_class.oid  INTO v_oid
     FROM
           pg_class
           INNER JOIN pg_namespace ON (pg_class.relnamespace = pg_namespace.oid AND lower(pg_namespace.nspname) = a_schema_name)
     WHERE
           pg_class.relname=a_table_name;
     IF NOT FOUND THEN
         RETURN;
     END IF;
 
     v_sql='
     SELECT
           pg_attribute.attname AS fields_name,
           pg_attribute.attnum AS fields_index,
           pgsql_type(pg_type.typname::varchar) AS fields_type,
           pg_attribute.atttypmod-4 as fields_length,
           CASE WHEN pg_attribute.attnotnull  THEN ''not null''
           ELSE ''''
           END AS fields_not_null,
           pg_get_expr(pg_attrdef.adbin, pg_attrdef.adrelid) AS fields_default,
           pg_description.description AS fields_comment
     FROM
           pg_attribute
           INNER JOIN pg_class  ON pg_attribute.attrelid = pg_class.oid
           INNER JOIN pg_type   ON pg_attribute.atttypid = pg_type.oid
           LEFT OUTER JOIN pg_attrdef ON pg_attrdef.adrelid = pg_class.oid AND pg_attrdef.adnum = pg_attribute.attnum
           LEFT OUTER JOIN pg_description ON pg_description.objoid = pg_class.oid AND pg_description.objsubid = pg_attribute.attnum
     WHERE
           pg_attribute.attnum > 0
           AND attisdropped <> ''t''
           AND pg_class.oid = ' || v_oid || '
     ORDER BY pg_attribute.attnum' ;
 
     FOR v_rec IN EXECUTE v_sql LOOP
         v_ret.fields_name=v_rec.fields_name;
         v_ret.fields_type=v_rec.fields_type;
         IF v_rec.fields_length > 0 THEN
            v_ret.fields_length:=v_rec.fields_length;
         ELSE
            v_ret.fields_length:=NULL;
         END IF;
         v_ret.fields_not_null=v_rec.fields_not_null;
         v_ret.fields_default=v_rec.fields_default;
         v_ret.fields_comment=v_rec.fields_comment;
         SELECT constraint_name INTO v_key FROM information_schema.key_column_usage WHERE table_schema=a_schema_name AND table_name=a_table_name AND column_name=v_rec.fields_name;
         IF FOUND THEN
            v_ret.fields_key_name=v_key;
         ELSE
            v_ret.fields_key_name='';
         END IF;
         RETURN NEXT v_ret;
     END LOOP;
     RETURN ;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
COMMENT ON FUNCTION "public"."table_msg"("a_schema_name" varchar, "a_table_name" varchar) IS '获得表信息';

-- ----------------------------
-- Function structure for uuid_generate_v1
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v1mc
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1mc"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1mc"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1mc'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v3
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v3"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v3"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v3'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v4
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v4"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v4"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v4'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v5
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v5"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v5"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v5'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_nil
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_nil"();
CREATE OR REPLACE FUNCTION "public"."uuid_nil"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_nil'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_dns
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_dns"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_dns"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_dns'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_oid
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_oid"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_oid"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_oid'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_url
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_url"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_url"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_url'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_x500
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_x500"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_x500"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_x500'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."acls_id_seq"', 36, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."api_keys_id_seq"
OWNED BY "public"."api_keys"."id";
SELECT setval('"public"."api_keys_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."logs_id_seq"', 313, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."machines_id_seq"
OWNED BY "public"."machines"."id";
SELECT setval('"public"."machines_id_seq"', 120, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pre_auth_key_acl_tags_id_seq"
OWNED BY "public"."pre_auth_key_acl_tags"."id";
SELECT setval('"public"."pre_auth_key_acl_tags_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pre_auth_keys_id_seq"
OWNED BY "public"."pre_auth_keys"."id";
SELECT setval('"public"."pre_auth_keys_id_seq"', 65, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."routes_id_seq"
OWNED BY "public"."routes"."id";
SELECT setval('"public"."routes_id_seq"', 34, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."users_id_seq"
OWNED BY "public"."users"."id";
SELECT setval('"public"."users_id_seq"', 42, true);

-- ----------------------------
-- Primary Key structure for table acls
-- ----------------------------
ALTER TABLE "public"."acls" ADD CONSTRAINT "acls_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table api_keys
-- ----------------------------
CREATE UNIQUE INDEX "idx_api_keys_prefix" ON "public"."api_keys" USING btree (
  "prefix" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table api_keys
-- ----------------------------
ALTER TABLE "public"."api_keys" ADD CONSTRAINT "api_keys_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table apis
-- ----------------------------
ALTER TABLE "public"."apis" ADD CONSTRAINT "menus_copy1_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table logs
-- ----------------------------
CREATE UNIQUE INDEX "logs_id_idx" ON "public"."logs" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table logs
-- ----------------------------
ALTER TABLE "public"."logs" ADD CONSTRAINT "logs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table machines
-- ----------------------------
ALTER TABLE "public"."machines" ADD CONSTRAINT "machines_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table menus
-- ----------------------------
ALTER TABLE "public"."menus" ADD CONSTRAINT "menus_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pre_auth_key_acl_tags
-- ----------------------------
ALTER TABLE "public"."pre_auth_key_acl_tags" ADD CONSTRAINT "pre_auth_key_acl_tags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pre_auth_keys
-- ----------------------------
ALTER TABLE "public"."pre_auth_keys" ADD CONSTRAINT "pre_auth_keys_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table roles
-- ----------------------------
ALTER TABLE "public"."roles" ADD CONSTRAINT "roles_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table routes
-- ----------------------------
CREATE INDEX "idx_routes_deleted_at" ON "public"."routes" USING btree (
  "deleted_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table routes
-- ----------------------------
ALTER TABLE "public"."routes" ADD CONSTRAINT "routes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table users
-- ----------------------------
CREATE INDEX "idx_users_deleted_at" ON "public"."users" USING btree (
  "deleted_at" "pg_catalog"."timestamptz_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_name_key" UNIQUE ("name");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");
