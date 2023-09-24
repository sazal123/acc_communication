-- DROP TABLE IF EXISTS public.acc_com_chats;

CREATE TABLE IF NOT EXISTS public.acc_com_chats
(
    id bigint NOT NULL DEFAULT nextval('acc_com_chats_id_seq'::regclass),
    uid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    udid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    company_id integer NOT NULL DEFAULT 0,
    is_group boolean NOT NULL DEFAULT false,
    is_active smallint NOT NULL DEFAULT '0'::smallint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT acc_com_chats_pkey PRIMARY KEY (id)
    );


-- DROP TABLE IF EXISTS public.acc_com_groups;

CREATE TABLE IF NOT EXISTS public.acc_com_groups
(
    id bigint NOT NULL DEFAULT nextval('acc_com_groups_id_seq'::regclass),
    uid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    udid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    company_id integer NOT NULL DEFAULT 0,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    avatar character varying(255) COLLATE pg_catalog."default",
    chat_id bigint NOT NULL,
    is_active smallint NOT NULL DEFAULT '0'::smallint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT acc_com_groups_pkey PRIMARY KEY (id),
    CONSTRAINT acc_com_groups_chat_id_unique UNIQUE (chat_id),
    CONSTRAINT acc_com_groups_chat_id_foreign FOREIGN KEY (chat_id)
    REFERENCES public.acc_com_chats (id) MATCH SIMPLE
                            ON UPDATE NO ACTION
                            ON DELETE CASCADE
    );
-- DROP TABLE IF EXISTS public.acc_com_messages;

CREATE TABLE IF NOT EXISTS public.acc_com_messages
(
    id bigint NOT NULL DEFAULT nextval('acc_com_messages_id_seq'::regclass),
    uid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    udid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    company_id integer NOT NULL DEFAULT 0,
    chat_id bigint NOT NULL,
    user_id bigint NOT NULL,
    content text COLLATE pg_catalog."default" NOT NULL,
    is_active smallint NOT NULL DEFAULT '0'::smallint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT acc_com_messages_pkey PRIMARY KEY (id),
    CONSTRAINT acc_com_messages_chat_id_foreign FOREIGN KEY (chat_id)
    REFERENCES public.acc_com_chats (id) MATCH SIMPLE
                            ON UPDATE NO ACTION
                            ON DELETE CASCADE,
    CONSTRAINT acc_com_messages_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES public.users (id) MATCH SIMPLE
                            ON UPDATE NO ACTION
                            ON DELETE CASCADE
    );
-- DROP TABLE IF EXISTS public.acc_com_participants;

CREATE TABLE IF NOT EXISTS public.acc_com_participants
(
    id bigint NOT NULL DEFAULT nextval('acc_com_participants_id_seq'::regclass),
    uid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    udid character varying(255) COLLATE pg_catalog."default" NOT NULL DEFAULT ''::character varying,
    company_id integer NOT NULL DEFAULT 0,
    chat_id bigint NOT NULL,
    user_id bigint NOT NULL,
    last_read_at timestamp(0) without time zone,
    is_active smallint NOT NULL DEFAULT '0'::smallint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT acc_com_participants_pkey PRIMARY KEY (id),
    CONSTRAINT acc_com_participants_chat_id_foreign FOREIGN KEY (chat_id)
    REFERENCES public.acc_com_chats (id) MATCH SIMPLE
                              ON UPDATE NO ACTION
                              ON DELETE CASCADE,
    CONSTRAINT acc_com_participants_user_id_foreign FOREIGN KEY (user_id)
    REFERENCES public.users (id) MATCH SIMPLE
                              ON UPDATE NO ACTION
                              ON DELETE CASCADE
    );

