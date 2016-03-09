--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.1.9
-- Started on 2013-11-29 04:23:55

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 11 (class 2615 OID 73755)
-- Name: app; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA app;


--
-- TOC entry 13 (class 2615 OID 73758)
-- Name: im; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA im;


--
-- TOC entry 12 (class 2615 OID 73757)
-- Name: omset; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA omset;


SET search_path = app, pg_catalog;

SET default_with_oids = false;

--
-- TOC entry 168 (class 1259 OID 46596)
-- Dependencies: 3275 3276 3277 11
-- Name: app_status; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE app_status (
    id integer NOT NULL,
    tahun integer,
    app_id smallint,
    step character varying(25),
    operator smallint DEFAULT 0 NOT NULL,
    review smallint DEFAULT 0 NOT NULL,
    manager smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 169 (class 1259 OID 46602)
-- Dependencies: 11 168
-- Name: app_status_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE app_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3384 (class 0 OID 0)
-- Dependencies: 169
-- Name: app_status_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE app_status_id_seq OWNED BY app_status.id;


--
-- TOC entry 204 (class 1259 OID 46776)
-- Dependencies: 3280 11
-- Name: apps; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE apps (
    id integer NOT NULL,
    nama character varying(50),
    app_path character varying(50),
    disabled smallint DEFAULT 1
);


--
-- TOC entry 205 (class 1259 OID 46780)
-- Dependencies: 11 204
-- Name: apps_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE apps_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3385 (class 0 OID 0)
-- Dependencies: 205
-- Name: apps_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE apps_id_seq OWNED BY apps.id;


--
-- TOC entry 289 (class 1259 OID 47184)
-- Dependencies: 3281 3282 3283 3284 11
-- Name: group_modules; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE group_modules (
    group_id integer,
    id integer NOT NULL,
    module_id integer,
    reads smallint DEFAULT 0 NOT NULL,
    writes smallint DEFAULT 0 NOT NULL,
    deletes smallint DEFAULT 0 NOT NULL,
    inserts smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 290 (class 1259 OID 47191)
-- Dependencies: 11 289
-- Name: group_modules_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE group_modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3386 (class 0 OID 0)
-- Dependencies: 290
-- Name: group_modules_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE group_modules_id_seq OWNED BY group_modules.id;


--
-- TOC entry 292 (class 1259 OID 47197)
-- Dependencies: 3287 11
-- Name: groups; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE groups (
    id integer NOT NULL,
    nama character varying(50),
    locked smallint DEFAULT 0,
    kode character varying(10)
);


--
-- TOC entry 293 (class 1259 OID 47201)
-- Dependencies: 11 292
-- Name: groups_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3387 (class 0 OID 0)
-- Dependencies: 293
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE groups_id_seq OWNED BY groups.id;


--
-- TOC entry 358 (class 1259 OID 47644)
-- Dependencies: 11
-- Name: modules; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE modules (
    id integer NOT NULL,
    nama character varying(50),
    app_id smallint,
    kode character varying(20)
);


--
-- TOC entry 359 (class 1259 OID 47647)
-- Dependencies: 11 358
-- Name: modules_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3388 (class 0 OID 0)
-- Dependencies: 359
-- Name: modules_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE modules_id_seq OWNED BY modules.id;


--
-- TOC entry 605 (class 1259 OID 49137)
-- Dependencies: 11
-- Name: user_groups; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE user_groups (
    id integer NOT NULL,
    user_id integer,
    group_id integer
);


--
-- TOC entry 606 (class 1259 OID 49140)
-- Dependencies: 11 605
-- Name: user_groups_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE user_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3389 (class 0 OID 0)
-- Dependencies: 606
-- Name: user_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE user_groups_id_seq OWNED BY user_groups.id;


--
-- TOC entry 612 (class 1259 OID 49155)
-- Dependencies: 11
-- Name: users; Type: TABLE; Schema: app; Owner: -
--

CREATE TABLE users (
    userid character varying(25),
    nama character varying(50),
    created timestamp without time zone,
    disabled smallint,
    passwd character varying(50),
    id integer NOT NULL,
    kd_kantor character(2),
    kd_kanwil character(2),
    kd_tp character(2),
    kd_kanwil_bank character(2),
    kd_kppbb_bank character(2),
    kd_bank_tunggal character(2),
    kd_bank_persepsi character(2),
    nip character(18),
    jabatan character varying(50)
);


--
-- TOC entry 613 (class 1259 OID 49158)
-- Dependencies: 11 612
-- Name: users_id_seq; Type: SEQUENCE; Schema: app; Owner: -
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3390 (class 0 OID 0)
-- Dependencies: 613
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: app; Owner: -
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


SET search_path = im, pg_catalog;

--
-- TOC entry 649 (class 1259 OID 73895)
-- Dependencies: 3296 3297 3298 3299 13
-- Name: agent; Type: TABLE; Schema: im; Owner: -
--

CREATE TABLE agent (
    id character varying(64) NOT NULL,
    jalur smallint NOT NULL,
    status smallint DEFAULT 0 NOT NULL,
    job smallint DEFAULT 0 NOT NULL,
    lastjob timestamp with time zone DEFAULT now() NOT NULL,
    startup timestamp with time zone DEFAULT now() NOT NULL,
    ket text,
    lasterr text,
    url name
);


--
-- TOC entry 648 (class 1259 OID 73874)
-- Dependencies: 13
-- Name: jalur; Type: TABLE; Schema: im; Owner: -
--

CREATE TABLE jalur (
    id smallint NOT NULL,
    nama character varying(20) NOT NULL
);


--
-- TOC entry 650 (class 1259 OID 73907)
-- Dependencies: 13
-- Name: ts100; Type: TABLE; Schema: im; Owner: -
--

CREATE TABLE ts100 (
    agent_id character varying(64) NOT NULL,
    op_id integer NOT NULL,
    latitude double precision,
    longitude double precision
);


SET search_path = omset, pg_catalog;

--
-- TOC entry 641 (class 1259 OID 73811)
-- Dependencies: 12
-- Name: bill; Type: TABLE; Schema: omset; Owner: -
--

CREATE TABLE bill (
    id integer NOT NULL,
    tgl timestamp with time zone,
    op_id integer NOT NULL,
    nominal double precision NOT NULL,
    jalur_id smallint NOT NULL,
    agent_id character varying(64) NOT NULL,
    ket_pengirim text,
    tgl_kirim timestamp with time zone NOT NULL,
    tgl_kwitansi timestamp with time zone NOT NULL,
    no_kwitansi character varying(64)
);


--
-- TOC entry 640 (class 1259 OID 73809)
-- Dependencies: 641 12
-- Name: bill_id_seq; Type: SEQUENCE; Schema: omset; Owner: -
--

CREATE SEQUENCE bill_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3391 (class 0 OID 0)
-- Dependencies: 640
-- Name: bill_id_seq; Type: SEQUENCE OWNED BY; Schema: omset; Owner: -
--

ALTER SEQUENCE bill_id_seq OWNED BY bill.id;


--
-- TOC entry 645 (class 1259 OID 73850)
-- Dependencies: 12
-- Name: bill_item; Type: TABLE; Schema: omset; Owner: -
--

CREATE TABLE bill_item (
    id integer NOT NULL,
    bill_id integer NOT NULL,
    nama_produk character varying(64) NOT NULL,
    jumlah double precision NOT NULL,
    nominal double precision NOT NULL,
    harga_satuan double precision,
    op_item_id integer
);


--
-- TOC entry 644 (class 1259 OID 73848)
-- Dependencies: 645 12
-- Name: bill_item_id_seq; Type: SEQUENCE; Schema: omset; Owner: -
--

CREATE SEQUENCE bill_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3392 (class 0 OID 0)
-- Dependencies: 644
-- Name: bill_item_id_seq; Type: SEQUENCE OWNED BY; Schema: omset; Owner: -
--

ALTER SEQUENCE bill_item_id_seq OWNED BY bill_item.id;


--
-- TOC entry 639 (class 1259 OID 73782)
-- Dependencies: 12
-- Name: objek_pajak; Type: TABLE; Schema: omset; Owner: -
--

CREATE TABLE objek_pajak (
    id integer NOT NULL,
    nama character varying(64) NOT NULL,
    jalan character varying(100),
    rt character(3),
    rw character(3),
    kelurahan character varying(50),
    kecamatan character varying(50),
    kabupaten character varying(50),
    propinsi character varying(50),
    kode_pos character varying(10),
    wp_id integer
);


--
-- TOC entry 638 (class 1259 OID 73780)
-- Dependencies: 639 12
-- Name: objek_pajak_id_seq; Type: SEQUENCE; Schema: omset; Owner: -
--

CREATE SEQUENCE objek_pajak_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3393 (class 0 OID 0)
-- Dependencies: 638
-- Name: objek_pajak_id_seq; Type: SEQUENCE OWNED BY; Schema: omset; Owner: -
--

ALTER SEQUENCE objek_pajak_id_seq OWNED BY objek_pajak.id;


--
-- TOC entry 643 (class 1259 OID 73840)
-- Dependencies: 12
-- Name: op_item; Type: TABLE; Schema: omset; Owner: -
--

CREATE TABLE op_item (
    id integer NOT NULL,
    op_id bigint,
    nama character varying(64) NOT NULL
);


--
-- TOC entry 642 (class 1259 OID 73838)
-- Dependencies: 643 12
-- Name: op_item_id_seq; Type: SEQUENCE; Schema: omset; Owner: -
--

CREATE SEQUENCE op_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3394 (class 0 OID 0)
-- Dependencies: 642
-- Name: op_item_id_seq; Type: SEQUENCE OWNED BY; Schema: omset; Owner: -
--

ALTER SEQUENCE op_item_id_seq OWNED BY op_item.id;


--
-- TOC entry 647 (class 1259 OID 73868)
-- Dependencies: 12
-- Name: wajib_pajak; Type: TABLE; Schema: omset; Owner: -
--

CREATE TABLE wajib_pajak (
    id integer NOT NULL,
    nama character varying(64) NOT NULL,
    jalan character varying(100),
    rt character(3),
    rw character(3),
    kelurahan character varying(50),
    kecamatan character varying(50),
    kabupaten character varying(50),
    propinsi character varying(50),
    kode_pos character varying(10),
    npwp character varying(64)
);


--
-- TOC entry 646 (class 1259 OID 73866)
-- Dependencies: 647 12
-- Name: wajib_pajak_id_seq; Type: SEQUENCE; Schema: omset; Owner: -
--

CREATE SEQUENCE wajib_pajak_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3395 (class 0 OID 0)
-- Dependencies: 646
-- Name: wajib_pajak_id_seq; Type: SEQUENCE OWNED BY; Schema: omset; Owner: -
--

ALTER SEQUENCE wajib_pajak_id_seq OWNED BY wajib_pajak.id;


SET search_path = app, pg_catalog;

--
-- TOC entry 3278 (class 2604 OID 49191)
-- Dependencies: 169 168
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY app_status ALTER COLUMN id SET DEFAULT nextval('app_status_id_seq'::regclass);


--
-- TOC entry 3279 (class 2604 OID 49204)
-- Dependencies: 205 204
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY apps ALTER COLUMN id SET DEFAULT nextval('apps_id_seq'::regclass);


--
-- TOC entry 3285 (class 2604 OID 49206)
-- Dependencies: 290 289
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY group_modules ALTER COLUMN id SET DEFAULT nextval('group_modules_id_seq'::regclass);


--
-- TOC entry 3286 (class 2604 OID 49207)
-- Dependencies: 293 292
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY groups ALTER COLUMN id SET DEFAULT nextval('groups_id_seq'::regclass);


--
-- TOC entry 3288 (class 2604 OID 49211)
-- Dependencies: 359 358
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY modules ALTER COLUMN id SET DEFAULT nextval('modules_id_seq'::regclass);


--
-- TOC entry 3289 (class 2604 OID 49241)
-- Dependencies: 606 605
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY user_groups ALTER COLUMN id SET DEFAULT nextval('user_groups_id_seq'::regclass);


--
-- TOC entry 3290 (class 2604 OID 49244)
-- Dependencies: 613 612
-- Name: id; Type: DEFAULT; Schema: app; Owner: -
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


SET search_path = omset, pg_catalog;

--
-- TOC entry 3292 (class 2604 OID 73814)
-- Dependencies: 640 641 641
-- Name: id; Type: DEFAULT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill ALTER COLUMN id SET DEFAULT nextval('bill_id_seq'::regclass);


--
-- TOC entry 3294 (class 2604 OID 73853)
-- Dependencies: 644 645 645
-- Name: id; Type: DEFAULT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill_item ALTER COLUMN id SET DEFAULT nextval('bill_item_id_seq'::regclass);


--
-- TOC entry 3291 (class 2604 OID 73785)
-- Dependencies: 638 639 639
-- Name: id; Type: DEFAULT; Schema: omset; Owner: -
--

ALTER TABLE ONLY objek_pajak ALTER COLUMN id SET DEFAULT nextval('objek_pajak_id_seq'::regclass);


--
-- TOC entry 3293 (class 2604 OID 73843)
-- Dependencies: 642 643 643
-- Name: id; Type: DEFAULT; Schema: omset; Owner: -
--

ALTER TABLE ONLY op_item ALTER COLUMN id SET DEFAULT nextval('op_item_id_seq'::regclass);


--
-- TOC entry 3295 (class 2604 OID 74016)
-- Dependencies: 646 647 647
-- Name: id; Type: DEFAULT; Schema: omset; Owner: -
--

ALTER TABLE ONLY wajib_pajak ALTER COLUMN id SET DEFAULT nextval('wajib_pajak_id_seq'::regclass);


SET search_path = app, pg_catalog;

--
-- TOC entry 3353 (class 0 OID 46596)
-- Dependencies: 168 3380
-- Data for Name: app_status; Type: TABLE DATA; Schema: app; Owner: -
--

COPY app_status (id, tahun, app_id, step, operator, review, manager) FROM stdin;
1	2011	4	renja	0	0	0
2	2012	1	1	0	0	0
\.


--
-- TOC entry 3396 (class 0 OID 0)
-- Dependencies: 169
-- Name: app_status_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('app_status_id_seq', 2, true);


--
-- TOC entry 3355 (class 0 OID 46776)
-- Dependencies: 204 3380
-- Data for Name: apps; Type: TABLE DATA; Schema: app; Owner: -
--

COPY apps (id, nama, app_path, disabled) FROM stdin;
7	TU PPKD	tuppkd	1
8	AKUNTANSI	akuntansi	1
9	KEPEGAWAIAN	pegawai	1
11	TPP	tpp	1
12	BARANG	barang	1
6	TU SKPKD	tuskpdkb	1
5	ANGGARAN	anggaran	1
1	PBB	pbb	0
3	POSPBB	pospbb	0
14	PBBM	pbbm	0
10	GAJI	gaji	1
2	BPHTB	bphtb	0
13	PAD	pad	0
15	BPTHB-SELF	bphtb_self	0
4	PERENCANAAN	perencanaan	0
16	Live Omset	live_omset	0
\.


--
-- TOC entry 3397 (class 0 OID 0)
-- Dependencies: 205
-- Name: apps_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('apps_id_seq', 16, true);


--
-- TOC entry 3357 (class 0 OID 47184)
-- Dependencies: 289 3380
-- Data for Name: group_modules; Type: TABLE DATA; Schema: app; Owner: -
--

COPY group_modules (group_id, id, module_id, reads, writes, deletes, inserts) FROM stdin;
2	2	4	0	0	0	0
2	3	5	0	0	0	0
2	1	3	1	0	0	0
5	5	1	0	0	0	0
5	6	2	0	0	0	0
5	7	6	1	1	1	1
3	9	4	1	1	1	1
3	10	5	1	1	1	1
3	4	3	1	1	1	1
3	11	13	1	1	1	1
6	8	8	1	1	0	1
7	20	21	1	1	1	1
7	19	20	1	1	1	1
7	18	19	1	1	1	1
7	17	18	1	1	1	1
7	16	17	1	1	1	1
7	15	16	1	1	1	1
7	14	15	1	1	1	1
7	13	14	1	1	1	1
7	12	6	1	1	1	1
\.


--
-- TOC entry 3398 (class 0 OID 0)
-- Dependencies: 290
-- Name: group_modules_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('group_modules_id_seq', 20, true);


--
-- TOC entry 3359 (class 0 OID 47197)
-- Dependencies: 292 3380
-- Data for Name: groups; Type: TABLE DATA; Schema: app; Owner: -
--

COPY groups (id, nama, locked, kode) FROM stdin;
3	POS Teller	0	\N
4	POS Supervisor	0	\N
1	Sys Admin	1	sa
2	Admin	1	ppat
5	PPAT	0	ppat
6	USER	0	user
7	BPHTB Group	0	bphtb
\.


--
-- TOC entry 3399 (class 0 OID 0)
-- Dependencies: 293
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('groups_id_seq', 7, true);


--
-- TOC entry 3361 (class 0 OID 47644)
-- Dependencies: 358 3380
-- Data for Name: modules; Type: TABLE DATA; Schema: app; Owner: -
--

COPY modules (id, nama, app_id, kode) FROM stdin;
1	Pendataan	1	DATA
2	Penilaian	1	TAP
3	POS Cetak	3	POSC
4	POS Batal	3	POSB
5	POS Salin	3	POSS
7	pendaftaran	13	pendaftaran
8	pendataan	13	pendataan
9	penetapan	13	penetapan
10	penerimaan	13	penerimaan
11	penagihan	13	penagihan
12	referensi	13	referensi
13	POS Laporan	3	POSL
14	SSPD/PPAT	2	ppat
15	Pelayanan	2	pelayanan
16	Penerimaan	2	penerimaan
17	Peneliti	2	peneliti
18	Penetapan	2	penetapan
19	Referensi	2	referensi
6	BPHTB PPAT	2	bphtbb
20	Laporan	2	laporan
21	BPN	2	bpn
\.


--
-- TOC entry 3400 (class 0 OID 0)
-- Dependencies: 359
-- Name: modules_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('modules_id_seq', 21, true);


--
-- TOC entry 3363 (class 0 OID 49137)
-- Dependencies: 605 3380
-- Data for Name: user_groups; Type: TABLE DATA; Schema: app; Owner: -
--

COPY user_groups (id, user_id, group_id) FROM stdin;
1	1	1
2	2	3
4	4	5
5	5	5
6	6	6
8	8	5
9	9	5
10	11	7
\.


--
-- TOC entry 3401 (class 0 OID 0)
-- Dependencies: 606
-- Name: user_groups_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('user_groups_id_seq', 10, true);


--
-- TOC entry 3365 (class 0 OID 49155)
-- Dependencies: 612 3380
-- Data for Name: users; Type: TABLE DATA; Schema: app; Owner: -
--

COPY users (userid, nama, created, disabled, passwd, id, kd_kantor, kd_kanwil, kd_tp, kd_kanwil_bank, kd_kppbb_bank, kd_bank_tunggal, kd_bank_persepsi, nip, jabatan) FROM stdin;
BA001	KANTOR PERTANAHAN KABUPATEN BOGOR	2013-04-27 00:00:00	0	sa	4	\N	\N	\N	\N	\N	\N	\N	\N	\N
CA001	Camat Babakan Madang	2013-06-05 00:00:00	0	sa	5	\N	\N	\N	\N	\N	\N	\N	\N	\N
ani	ANI POS	\N	0	a	2	19	09	22	\N	\N	\N	\N	88888888888       	\N
user	Pengguna Umum	2013-08-02 00:00:00	0	user	6	\N	\N	\N	\N	\N	\N	\N	\N	\N
sa	Super Administrator	\N	0	sa	1	19	09	44	09	01	01	01	999999999999999999	\N
irul	IRUL	\N	\N	irul	7	\N	\N	\N	\N	\N	\N	\N	\N	\N
ppat2	PPAT 2	2013-10-27 00:00:00	0	ppat2	9	\N	\N	\N	\N	\N	\N	\N	\N	\N
ppat1	PPAT 1	2013-10-22 00:00:00	0	ppat1	8	\N	\N	\N	\N	\N	\N	\N	\N	\N
zz	zzzz	2013-11-10 00:00:00	0	zz	10	\N	\N	\N	\N	\N	\N	\N	1234123           	23sadfv adfawdf awfd waef
bphtb	BPHTB User	2013-11-23 00:00:00	0	bphtb	11	\N	\N	\N	\N	\N	\N	\N	1234              	User
\.


--
-- TOC entry 3402 (class 0 OID 0)
-- Dependencies: 613
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: app; Owner: -
--

SELECT pg_catalog.setval('users_id_seq', 11, true);


SET search_path = im, pg_catalog;

--
-- TOC entry 3378 (class 0 OID 73895)
-- Dependencies: 649 3380
-- Data for Name: agent; Type: TABLE DATA; Schema: im; Owner: -
--

COPY agent (id, jalur, status, job, lastjob, startup, ket, lasterr, url) FROM stdin;
AG001	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG002	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG003	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG004	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG005	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG006	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG007	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG008	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG009	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
AG010	7	1	0	2013-01-01 00:00:00+07	2013-01-01 00:00:00+07	Ok	\N	\N
\.


--
-- TOC entry 3377 (class 0 OID 73874)
-- Dependencies: 648 3380
-- Data for Name: jalur; Type: TABLE DATA; Schema: im; Owner: -
--

COPY jalur (id, nama) FROM stdin;
7	ts-100
\.


--
-- TOC entry 3379 (class 0 OID 73907)
-- Dependencies: 650 3380
-- Data for Name: ts100; Type: TABLE DATA; Schema: im; Owner: -
--

COPY ts100 (agent_id, op_id, latitude, longitude) FROM stdin;
AG001	102030302	\N	\N
AG002	100030302	\N	\N
AG003	99010502	\N	\N
AG004	98010502	\N	\N
AG005	97040702	\N	\N
AG006	96020402	\N	\N
AG007	95010502	\N	\N
AG008	94020202	\N	\N
AG009	93010502	\N	\N
AG010	92010502	\N	\N
\.


SET search_path = omset, pg_catalog;

--
-- TOC entry 3370 (class 0 OID 73811)
-- Dependencies: 641 3380
-- Data for Name: bill; Type: TABLE DATA; Schema: omset; Owner: -
--

COPY bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) FROM stdin;
5	2013-11-16 00:00:00+07	97040702	1571200	7	AG005	IMPORT FROM	2013-11-16 00:00:00+07	2013-11-16 00:00:00+07	
6	2013-11-14 00:00:00+07	96020402	16212585	7	AG006	IMPORT FROM	2013-11-14 00:00:00+07	2013-11-14 00:00:00+07	
201334968	2013-01-16 00:00:00+07	97040702	1571200	7	AG005	IMPORT FROM	2013-01-16 00:00:00+07	2013-01-16 00:00:00+07	
7	2013-11-14 00:00:00+07	94020202	44164818	7	AG008	IMPORT FROM	2013-11-14 00:00:00+07	2013-11-14 00:00:00+07	
8	2013-11-15 00:00:00+07	93010502	1097420	7	AG009	IMPORT FROM	2013-11-15 00:00:00+07	2013-11-15 00:00:00+07	
9	2013-11-11 00:00:00+07	100030302	12553364	7	AG002	IMPORT FROM	2013-11-11 00:00:00+07	2013-11-11 00:00:00+07	
10	2013-11-15 00:00:00+07	102030302	5353400	7	AG001	IMPORT FROM	2013-11-15 00:00:00+07	2013-11-15 00:00:00+07	
11	2013-11-10 00:00:00+07	92010502	25786472	7	AG010	IMPORT FROM	2013-11-10 00:00:00+07	2013-11-10 00:00:00+07	
12	2013-11-11 00:00:00+07	98010502	9882125	7	AG004	IMPORT FROM	2013-11-11 00:00:00+07	2013-11-11 00:00:00+07	
201335016	2013-01-14 00:00:00+07	96020402	16212585	7	AG006	IMPORT FROM	2013-01-14 00:00:00+07	2013-01-14 00:00:00+07	
14	2013-10-16 00:00:00+07	97040702	1271200	7	AG005	IMPORT FROM	2013-10-16 00:00:00+07	2013-10-16 00:00:00+07	
201335032	2013-01-14 00:00:00+07	94020202	44164818	7	AG008	IMPORT FROM	2013-01-14 00:00:00+07	2013-01-14 00:00:00+07	
15	2013-10-14 00:00:00+07	96020402	16212585	7	AG006	IMPORT FROM	2013-10-14 00:00:00+07	2013-10-14 00:00:00+07	
16	2013-10-14 00:00:00+07	94020202	40164818	7	AG008	IMPORT FROM	2013-10-14 00:00:00+07	2013-10-14 00:00:00+07	
17	2013-10-15 00:00:00+07	93010502	1497420	7	AG009	IMPORT FROM	2013-10-15 00:00:00+07	2013-10-15 00:00:00+07	
18	2013-10-11 00:00:00+07	100030302	18553364	7	AG002	IMPORT FROM	2013-10-11 00:00:00+07	2013-10-11 00:00:00+07	
19	2013-10-15 00:00:00+07	102030302	4053400	7	AG001	IMPORT FROM	2013-10-15 00:00:00+07	2013-10-15 00:00:00+07	
20	2013-10-10 00:00:00+07	92010502	20786472	7	AG010	IMPORT FROM	2013-10-10 00:00:00+07	2013-10-10 00:00:00+07	
21	2013-10-11 00:00:00+07	98010502	8982125	7	AG004	IMPORT FROM	2013-10-11 00:00:00+07	2013-10-11 00:00:00+07	
23	2013-12-16 00:00:00+07	97040702	1871200	7	AG005	IMPORT FROM	2013-12-16 00:00:00+07	2013-12-16 00:00:00+07	
24	2013-12-14 00:00:00+07	96020402	13212585	7	AG006	IMPORT FROM	2013-12-14 00:00:00+07	2013-12-14 00:00:00+07	
25	2013-12-14 00:00:00+07	94020202	44164818	7	AG008	IMPORT FROM	2013-12-14 00:00:00+07	2013-12-14 00:00:00+07	
26	2013-12-15 00:00:00+07	93010502	1197420	7	AG009	IMPORT FROM	2013-12-15 00:00:00+07	2013-12-15 00:00:00+07	
27	2013-12-11 00:00:00+07	100030302	13553364	7	AG002	IMPORT FROM	2013-12-11 00:00:00+07	2013-12-11 00:00:00+07	
28	2013-12-15 00:00:00+07	102030302	4353400	7	AG001	IMPORT FROM	2013-12-15 00:00:00+07	2013-12-15 00:00:00+07	
201335020	2013-01-15 00:00:00+07	93010502	1097420	7	AG009	IMPORT FROM	2013-01-15 00:00:00+07	2013-01-15 00:00:00+07	
29	2013-12-10 00:00:00+07	92010502	23786472	7	AG010	IMPORT FROM	2013-12-10 00:00:00+07	2013-12-10 00:00:00+07	
30	2013-12-11 00:00:00+07	98010502	9282125	7	AG004	IMPORT FROM	2013-12-11 00:00:00+07	2013-12-11 00:00:00+07	
201332729	2013-01-11 00:00:00+07	100030302	12553364	7	AG002	IMPORT FROM	2013-01-11 00:00:00+07	2013-01-11 00:00:00+07	
201332826	2013-01-15 00:00:00+07	102030302	5353400	7	AG001	IMPORT FROM	2013-01-15 00:00:00+07	2013-01-15 00:00:00+07	
201332906	2013-01-10 00:00:00+07	92010502	25786472	7	AG010	IMPORT FROM	2013-01-10 00:00:00+07	2013-01-10 00:00:00+07	
201335892	2013-01-11 00:00:00+07	98010502	9882125	7	AG004	IMPORT FROM	2013-01-11 00:00:00+07	2013-01-11 00:00:00+07	
\.


--
-- TOC entry 3403 (class 0 OID 0)
-- Dependencies: 640
-- Name: bill_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: -
--

SELECT pg_catalog.setval('bill_id_seq', 31, true);


--
-- TOC entry 3374 (class 0 OID 73850)
-- Dependencies: 645 3380
-- Data for Name: bill_item; Type: TABLE DATA; Schema: omset; Owner: -
--

COPY bill_item (id, bill_id, nama_produk, jumlah, nominal, harga_satuan, op_item_id) FROM stdin;
\.


--
-- TOC entry 3404 (class 0 OID 0)
-- Dependencies: 644
-- Name: bill_item_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: -
--

SELECT pg_catalog.setval('bill_item_id_seq', 3, true);


--
-- TOC entry 3368 (class 0 OID 73782)
-- Dependencies: 639 3380
-- Data for Name: objek_pajak; Type: TABLE DATA; Schema: omset; Owner: -
--

COPY objek_pajak (id, nama, jalan, rt, rw, kelurahan, kecamatan, kabupaten, propinsi, kode_pos, wp_id) FROM stdin;
32030502	RESTORAN	SENTRA MENTENG PD.AREN	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			320305
34030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			340305
36030502	RESTORAN	BINTARO SEKTOR IX	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			360305
37030502	RESTORAN	BTC BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			370305
38030502	RESTORAN	PLAZA BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			380305
39030502	RESTORAN	PLAZA BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			390305
41010502	RESTORAN	BSD	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			410105
44030502	RESTORAN	PLAZA BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			440305
46010502	RESTORAN	RUKO BLOK RG BSD	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			460105
49020502	RESTORAN	JL.RAYA SERPONG KM.7	   	   	PAKUALAM	SERPONG UTARA	TANGERANG SELATAN			490205
50010502	RESTORAN	BSD PLAZA	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			500105
51010502	RESTORAN	BSD PLAZA	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			510105
53020202	RESTORAN	JL.RAYA SERPONG	   	   	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			530202
54010402	RESTORAN	GIANT	   	   	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			540104
55010402	RESTORAN	GIANT	   	   	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			550104
56020302	RESTORAN	WTC MATAHARI	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			560203
60020202	RESTORAN	LINGKAR TIMUR BSD	   	   	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			600202
61020302	RESTORAN	WTC MATAHARI SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			610203
62020302	RESTORAN	WTC MATAHARI SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			620203
63020302	RESTORAN	JL.RAYA SERPONG WTC	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			630203
64010502	RESTORAN	BSD LENGKONG WETAN	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			640105
66010502	RESTORAN	BSD PLAZA SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			660105
67010502	RESTORAN	BSD PLAZA SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			670105
68020302	RESTORAN	BSD PLAZA SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			680203
69020302	RESTORAN	WTC MATAHARI SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			690203
71020502	RESTORAN	JL.RAYA SERPONG	   	   	PAKUALAM	SERPONG UTARA	TANGERANG SELATAN			710205
72010502	RESTORAN	ITC BSD SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			720105
73020302	RESTORAN	WTC MATAHARI SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			730203
75060102	RESTORAN	JL.RAYA PAMULANG	   	   	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			750601
76060502	RESTORAN	JL.RAYA PONDOK CABE,RUKO PD CABE MUTIARA	   	   	PONDOK CABE ILIR	PAMULANG	TANGERANG SELATAN			760605
77040702	RESTORAN	JL.DEWI SARTIKA	   	   	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			770407
79040702	RESTORAN	JL.RAYA CIPUTAT	   	   	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			790407
80050202	RESTORAN	HERO SUPERMARKET	   	   	CIREUNDEU	CIPUTAT TIMUR	TANGERANG SELATAN			800502
81050202	RESTORAN	PISANGAN CIPUTAT	   	   	CIREUNDEU	CIPUTAT TIMUR	TANGERANG SELATAN			810502
84050502	RESTORAN	JL.RAYA CIPUTAT	   	   	CEMPAKA PUTIH	CIPUTAT TIMUR	TANGERANG SELATAN			840505
85060102	RESTORAN	JL.SILIWANGI NO.9 PAMULANG	   	   	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			850601
86010502	RESTORAN	ITC SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			860105
87010502	RESTORAN	FOOD COURT ITC SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			870105
88010502	RESTORAN	ITC BSD SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			880105
35030502	RESTORAN	RUKO MENTENG BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			350305
42030502	RESTORAN	BTC BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			420305
43030502	RESTORAN	BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			430305
47020302	RESTORAN	JL.RAYA SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			470203
48010402	RESTORAN	RUKO VILLA MELATI MAS	   	   	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			480104
57020302	RESTORAN	WTC MATAHARI	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			570203
58020302	RESTORAN	ALAM SUTERA	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			580203
70020202	RESTORAN	ALAM SUTERA SERPONG	   	   	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			700202
83040702	RESTORAN	JL.RAYA CIPUTAT	   	   	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			830407
33030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			330305
74060102	RESTORAN	HERO PAMULANG	   	   	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			740601
90010502	RESTORAN	GEDUNG ITC BSD JL.RAYA SERPONG SEK VII	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			900105
91060102	RESTORAN	PAMULANG	   	   	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			910601
95010502	RESTORAN	ITC SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			950105
96020402	RESTORAN	JL.RAYA SERPONG,MELATI MAS BLOK AI NO.10	   	   	JELUPANG	SERPONG UTARA	TANGERANG SELATAN			960204
97040702	RESTORAN	JL.RAYA CIPUTAT	   	   	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			970407
98010502	RESTORAN	ITC BSD SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			980105
100030302	RESTORAN	JL.RAYA BINTARO UTAMA GRAHA MARSELA .III	   	   	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			1000303
102030302	RESTORAN	JL.MANDAR RAYA BLOK DD.1/73 SEKT.III	   	   	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			1020303
99010502	RESTORAN	ITC BSD SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			990105
15030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			150305
40030502	RESTORAN	BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			400305
45010402	RESTORAN	RUKO VILLA MELATI MAS	   	   	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			450104
52010202	RESTORAN	GRIYA LOKA BSD	   	   	RAWA BUNTU	SERPONG	TANGERANG SELATAN			520102
82040702	RESTORAN	JL.RE.MARTADINATA	   	   	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			820407
89050602	RESTORAN	JL.W.R SUPRATMAN	   	   	PONDOK RANJI	CIPUTAT TIMUR	TANGERANG SELATAN			890506
23030502	RESTORAN	ALFA BINTARO SEKT. VII	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			230305
92010502	HOTEL	ITC SERPONG	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			920105
94020202	HIBURAN	JL.RAYA SERPONG	   	   	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			940202
28010402	RESTORAN	RUKO VILLA MELATI MAS	   	   	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			280104
59020302	RESTORAN	WTC MATAHARI	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			590203
65020302	RESTORAN	WTC MATAHARI SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			650203
93010502	RESTORAN	RUKO BLOK S106/107 ITC	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			930105
5020302	RESTORAN	JL.RAYA SERPONG	   	   	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			50203
6010502	RESTORAN	BSD PLAZA	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			60105
7010502	RESTORAN	BSD PLAZA SEK.VII	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			70105
8010502	RESTORAN	BSD SEK VII BLK.E/48	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			80105
9010502	RESTORAN	BSD	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			90105
10010502	RESTORAN	BSD SEKT.IV BSD PLAZA	   	   	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			100105
11030502	RESTORAN	BINTARO SEKT.IX	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			110305
12030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			120305
13030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			130305
14030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			140305
16030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			160305
17030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			170305
18030502	RESTORAN	ALFA BINTARO SEKT.VII	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			180305
19030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			190305
20030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			200305
21030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			210305
22030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			220305
24030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			240305
25030302	RESTORAN	BINTARO SEKT.III	   	   	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			250303
26030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			260305
27030502	RESTORAN	BINTARO PLAZA	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			270305
29030402	RESTORAN	PONDOK JAYA BINTARO	   	   	PONDOK JAYA	PONDOK AREN	TANGERANG SELATAN			290304
30030502	RESTORAN	RUKO MENTENG BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			300305
31030502	RESTORAN	RUKO MENTENG BINTARO	   	   	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			310305
1020201	HOTEL	JL.RAYA SERPONG	   	   	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			10202
2040301	HOTEL	JL.RAYA CIPUTAT	   	   	CIPUTAT	CIPUTAT	TANGERANG SELATAN			20403
3030301	HOTEL	JL.RAYA BINTARO	   	   	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			30303
4010301	HOTEL	RUKO BSD MADRID RAWA MEKAR JAYA SERPONG	   	   	RAWA MEKAR JAYA	SERPONG	TANGERANG SELATAN			40103
\.


--
-- TOC entry 3405 (class 0 OID 0)
-- Dependencies: 638
-- Name: objek_pajak_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: -
--

SELECT pg_catalog.setval('objek_pajak_id_seq', 10, true);


--
-- TOC entry 3372 (class 0 OID 73840)
-- Dependencies: 643 3380
-- Data for Name: op_item; Type: TABLE DATA; Schema: omset; Owner: -
--

COPY op_item (id, op_id, nama) FROM stdin;
\.


--
-- TOC entry 3406 (class 0 OID 0)
-- Dependencies: 642
-- Name: op_item_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: -
--

SELECT pg_catalog.setval('op_item_id_seq', 5, true);


--
-- TOC entry 3376 (class 0 OID 73868)
-- Dependencies: 647 3380
-- Data for Name: wajib_pajak; Type: TABLE DATA; Schema: omset; Owner: -
--

COPY wajib_pajak (id, nama, jalan, rt, rw, kelurahan, kecamatan, kabupaten, propinsi, kode_pos, npwp) FROM stdin;
10202	HOTEL MELATI	JL.RAYA SERPONG	\N	\N	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			P200000010202
20403	WISMA PD.WISATA SITU GINTUNG	JL.RAYA CIPUTAT	\N	\N	CIPUTAT	CIPUTAT	TANGERANG SELATAN			P200000020403
30303	HOTEL BINTARO	JL.RAYA BINTARO	\N	\N	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			P200000030303
40103	HOTEL BUKIT SION DAMAI	RUKO BSD MADRID RAWA MEKAR JAYA SERPONG	\N	\N	RAWA MEKAR JAYA	SERPONG	TANGERANG SELATAN			P200000040103
50203	SWIEKE PURWODADI	JL.RAYA SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000050203
60105	PT.REKSO NASIONAL FOOD/ MC DONALD\\047S	BSD PLAZA	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000060105
70105	PT.FAST FOOD INDONESIA/KFC	BSD PLAZA SEK.VII	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000070105
80105	PT.SARI MELATI KENCANA/PIZZA HUT	BSD SEK VII BLK.E/48	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000080105
90105	PT.DAMAI INDAH GOLF	BSD	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000090105
100105	MINI KAFE/BEZZA CAFE	BSD SEKT.IV BSD PLAZA	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000100105
110305	PT.REKSO NASIONAL FOOD/ MC DONALD\\047S	BINTARO SEKT.IX	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000110305
120305	PT.EKA BOGA INTI/HOKA HOKA BENTO	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000120305
130305	PT.SARI MELATI KENCANA/PIZZA HUT	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000130305
140305	PT.FAST FOOD INDONESIA/KFC	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000140305
150305	PT.WENDY\\047S CITRA RASA	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000150305
160305	PT.AMERICAN HAMBURGER	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000160305
170305	PT.CIPTA SELERA MURNI/TEXAS FRIED CHIKEN	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000170305
180305	BIRU FASTFOOD NUSANTARA,PT/A&W BINTARO	ALFA BINTARO SEKT.VII	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000180305
190305	BAKMI GANG KELINCI	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000190305
200305	HANAMASA YAKINIKU	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000200305
210305	HOT PLANET	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000210305
220305	BAKSO SOLARIA	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000220305
230305	NORISHIMA	ALFA BINTARO SEKT. VII	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000230305
240305	PT.DUNKINDO LESTARI	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000240305
250303	PD.SATE KAMBING MUDA I	BINTARO SEKT.III	\N	\N	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			P200000250303
260305	ES TELLER 77	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000260305
270305	KANTIN BIOSKOP 21	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000270305
280104	RM.SUHARTI	RUKO VILLA MELATI MAS	\N	\N	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			P200000280104
290304	PT.DUNKINDO LESTARI/TOPS BINTARO	PONDOK JAYA BINTARO	\N	\N	PONDOK JAYA	PONDOK AREN	TANGERANG SELATAN			P200000290304
300305	MIDORI	RUKO MENTENG BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000300305
310305	PAPA RONS PIZZA	RUKO MENTENG BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000310305
320305	AYAM GORENG BAKUL	SENTRA MENTENG PD.AREN	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000320305
330305	CAFE OH LA LA	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000330305
340305	MM.JUICE/PT.GOLDEN DOLBE	BINTARO PLAZA	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000340305
350305	RM.SEDERHANA BINTARO	RUKO MENTENG BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000350305
360305	BAKMI JAPOS	BINTARO SEKTOR IX	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000360305
370305	AYAM TULANG LUNAK	BTC BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000370305
380305	RED BEAN	PLAZA BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000380305
390305	POTATO	PLAZA BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000390305
400305	SOTO EYANG PUTRI	BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000400305
410105	PT.DUNKINDO LESTARI	BSD	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000410105
420305	YONGKEE	BTC BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000420305
430305	DJ\\047STEAK	BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000430305
440305	CV.CAHAYA SAKTI/TAMANI CAFE	PLAZA BINTARO	\N	\N	PONDOK AREN	PONDOK AREN	TANGERANG SELATAN			P200000440305
450104	FURAMI RESTORAN	RUKO VILLA MELATI MAS	\N	\N	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			P200000450104
460105	RESTORAN SARI KURING	RUKO BLOK RG BSD	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000460105
470203	RM.PONDOK JAGUNG	JL.RAYA SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000470203
480104	RM.PONDOK PESANGGRAHAN	RUKO VILLA MELATI MAS	\N	\N	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			P200000480104
490205	RM.RODA HIDUP	JL.RAYA SERPONG KM.7	\N	\N	PAKUALAM	SERPONG UTARA	TANGERANG SELATAN			P200000490205
500105	KANTIN BIOSKOP BSD 21	BSD PLAZA	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000500105
510105	BAKMI NAGA	BSD PLAZA	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000510105
520102	BAKMI JAPOS	GRIYA LOKA BSD	\N	\N	RAWA BUNTU	SERPONG	TANGERANG SELATAN			P200000520102
530202	RM.PAK.JO/PECEL LELE	JL.RAYA SERPONG	\N	\N	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			P200000530202
540104	PT.FAST FOOD INDONESIA/KFC	GIANT	\N	\N	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			P200000540104
550104	HOKA HOKA BENTO	GIANT	\N	\N	LENGKONG GUDANG	SERPONG	TANGERANG SELATAN			P200000550104
560203	PT.FAST FOOD INDONESIA/KFC	WTC MATAHARI	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000560203
570203	TEXAS FRIED CHICKEN	WTC MATAHARI	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000570203
580203	FOOD COURT FAMILY PARK	ALAM SUTERA	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000580203
590203	MISTER BASO	WTC MATAHARI	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000590203
600202	DJ\\047S STEAK	LINGKAR TIMUR BSD	\N	\N	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			P200000600202
610203	BAKSO SOLARIA WTC	WTC MATAHARI SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000610203
620203	PT.JADDI PASTRISINDO GEMILANG/D\\047CREPES	WTC MATAHARI SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000620203
630203	RM.SEDERHANA	JL.RAYA SERPONG WTC	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000630203
640105	RM.SIMPANG RAYA	BSD LENGKONG WETAN	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000640105
650203	BASO AFUNG	WTC MATAHARI SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000650203
660105	CV.CAHAYA SAKTI/TAMANI CAFE	BSD PLAZA SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000660105
670105	JAMAL PORTAL	BSD PLAZA SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000670105
680203	IKO BENTO	BSD PLAZA SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000680203
690203	KANTIN BIOSKOP 21 WTC	WTC MATAHARI SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000690203
700202	DJ\\047S STEAK BBQ KAMPUNG AIR	ALAM SUTERA SERPONG	\N	\N	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			P200000700202
710205	WARUNG SOTO KUDUS	JL.RAYA SERPONG	\N	\N	PAKUALAM	SERPONG UTARA	TANGERANG SELATAN			P200000710205
720105	A&W RESTORAN ITC	ITC BSD SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000720105
730203	SHOKUYOKU TEPPAYAKI	WTC MATAHARI SERPONG	\N	\N	PONDOK JAGUNG	SERPONG UTARA	TANGERANG SELATAN			P200000730203
740601	PT.DUNKINDO LESTARI	HERO PAMULANG	\N	\N	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			P200000740601
750601	AYAM GORENG MBOK BEREK	JL.RAYA PAMULANG	\N	\N	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			P200000750601
760605	RM SEDERHANA	JL.RAYA PONDOK CABE,RUKO PD CABE MUTIARA	\N	\N	PONDOK CABE ILIR	PAMULANG	TANGERANG SELATAN			P200000760605
770407	PT.FAST FOOD INDONESIA/KFC	JL.DEWI SARTIKA	\N	\N	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			P200000770407
790407	AYAM PANGGANG SITU GINTUNG	JL.RAYA CIPUTAT	\N	\N	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			P200000790407
800502	PT.DUNKINDO LESTARI	HERO SUPERMARKET	\N	\N	CIREUNDEU	CIPUTAT TIMUR	TANGERANG SELATAN			P200000800502
810502	RM.SATE KAMBING MUDA II	PISANGAN CIPUTAT	\N	\N	CIREUNDEU	CIPUTAT TIMUR	TANGERANG SELATAN			P200000810502
820407	AYAM GORENG MBOK BEREK	JL.RE.MARTADINATA	\N	\N	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			P200000820407
830407	PT.PIONEERINDO GOURMENT INT/CFC	JL.RAYA CIPUTAT	\N	\N	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			P200000830407
840505	PT.SARI MELATI/PIZZA HUT	JL.RAYA CIPUTAT	\N	\N	CEMPAKA PUTIH	CIPUTAT TIMUR	TANGERANG SELATAN			P200000840505
850601	PT.SARI MELATI KENCANA / PIZZA HUT	JL.SILIWANGI NO.9 PAMULANG	\N	\N	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			P200000850601
860105	PT.SARI MELATI KENCANA/PIZZA HUT	ITC SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000860105
870105	PT.FAST FOOD INDONESIA/K F C	FOOD COURT ITC SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000870105
880105	SNACK CORNER CARREFOUR ITC BSD	ITC BSD SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000880105
890506	PT.INDONESIA AMERICA HOUSING/MAHOGANI	JL.W.R SUPRATMAN	\N	\N	PONDOK RANJI	CIPUTAT TIMUR	TANGERANG SELATAN			P200000890506
900105	MISTER BASO INDONESIA	GEDUNG ITC BSD JL.RAYA SERPONG SEK VII	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000900105
910601	NASI TIMBEL SELERA KURING	PAMULANG	\N	\N	PAMULANG BARAT	PAMULANG	TANGERANG SELATAN			P200000910601
920105	PT.FAST FOOD INDONESIA / KFC	ITC SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000920105
930105	SARPINO\\047S PIZZERIA	RUKO BLOK S106/107 ITC	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000930105
940202	SUPER KITCHEN /CV.MAJU MAKMUR SEJAHTERA	JL.RAYA SERPONG	\N	\N	PAKULONAN	SERPONG UTARA	TANGERANG SELATAN			P200000940202
950105	SHOKUYOKU TEPPANYAKI	ITC SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000950105
960204	RM.AYAM PRESTO NY.NITA	JL.RAYA SERPONG,MELATI MAS BLOK AI NO.10	\N	\N	JELUPANG	SERPONG UTARA	TANGERANG SELATAN			P200000960204
970407	FIFO CAFE RESTO	JL.RAYA CIPUTAT	\N	\N	CIPAYUNG	CIPUTAT	TANGERANG SELATAN			P200000970407
980105	PT.PIONERERINDO GOURMET INT.TBK/ CFC	ITC BSD SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000980105
990105	BAKMI NAGA	ITC BSD SERPONG	\N	\N	LENGKONG WETAN	SERPONG	TANGERANG SELATAN			P200000990105
1000303	PT.PRIMA USAHA ERA MANDIRI/A&W RESTORAN	JL.RAYA BINTARO UTAMA GRAHA MARSELA .III	\N	\N	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			P200001000303
1020303	RM SEDERHANA BINTARO	JL.MANDAR RAYA BLOK DD.1/73 SEKT.III	\N	\N	PONDOK KARYA	PONDOK AREN	TANGERANG SELATAN			P200001020303
\.


--
-- TOC entry 3407 (class 0 OID 0)
-- Dependencies: 646
-- Name: wajib_pajak_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: -
--

SELECT pg_catalog.setval('wajib_pajak_id_seq', 3, true);


SET search_path = app, pg_catalog;

--
-- TOC entry 3301 (class 2606 OID 49246)
-- Dependencies: 168 168 3381
-- Name: app_status_pkey; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY app_status
    ADD CONSTRAINT app_status_pkey PRIMARY KEY (id);


--
-- TOC entry 3303 (class 2606 OID 49312)
-- Dependencies: 204 204 3381
-- Name: apps_nama_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY apps
    ADD CONSTRAINT apps_nama_key UNIQUE (nama);


--
-- TOC entry 3307 (class 2606 OID 49324)
-- Dependencies: 289 289 289 3381
-- Name: group_modules_group_id_module_id_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY group_modules
    ADD CONSTRAINT group_modules_group_id_module_id_key UNIQUE (group_id, module_id);


--
-- TOC entry 3309 (class 2606 OID 49326)
-- Dependencies: 289 289 3381
-- Name: group_modules_pkey; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY group_modules
    ADD CONSTRAINT group_modules_pkey PRIMARY KEY (id);


--
-- TOC entry 3311 (class 2606 OID 49328)
-- Dependencies: 292 292 3381
-- Name: groups_nama_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_nama_key UNIQUE (nama);


--
-- TOC entry 3313 (class 2606 OID 49330)
-- Dependencies: 292 292 3381
-- Name: groups_pkey; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- TOC entry 3315 (class 2606 OID 49342)
-- Dependencies: 358 358 358 3381
-- Name: modules_nama_app_id_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY modules
    ADD CONSTRAINT modules_nama_app_id_key UNIQUE (nama, app_id);


--
-- TOC entry 3305 (class 2606 OID 49418)
-- Dependencies: 204 204 3381
-- Name: pk_apps; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY apps
    ADD CONSTRAINT pk_apps PRIMARY KEY (id);


--
-- TOC entry 3317 (class 2606 OID 49835)
-- Dependencies: 358 358 3381
-- Name: pk_modules; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY modules
    ADD CONSTRAINT pk_modules PRIMARY KEY (id);


--
-- TOC entry 3319 (class 2606 OID 50099)
-- Dependencies: 605 605 3381
-- Name: user_groups_pkey; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY user_groups
    ADD CONSTRAINT user_groups_pkey PRIMARY KEY (id);


--
-- TOC entry 3321 (class 2606 OID 50101)
-- Dependencies: 605 605 605 3381
-- Name: user_groups_user_id_group_id_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY user_groups
    ADD CONSTRAINT user_groups_user_id_group_id_key UNIQUE (user_id, group_id);


--
-- TOC entry 3323 (class 2606 OID 50113)
-- Dependencies: 612 612 3381
-- Name: users_pkey; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3325 (class 2606 OID 50115)
-- Dependencies: 612 612 3381
-- Name: users_userid_key; Type: CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_userid_key UNIQUE (userid);


SET search_path = im, pg_catalog;

--
-- TOC entry 3339 (class 2606 OID 73906)
-- Dependencies: 649 649 3381
-- Name: agent_pkey; Type: CONSTRAINT; Schema: im; Owner: -
--

ALTER TABLE ONLY agent
    ADD CONSTRAINT agent_pkey PRIMARY KEY (id);


--
-- TOC entry 3341 (class 2606 OID 73948)
-- Dependencies: 650 650 650 3381
-- Name: ts100_pkey; Type: CONSTRAINT; Schema: im; Owner: -
--

ALTER TABLE ONLY ts100
    ADD CONSTRAINT ts100_pkey PRIMARY KEY (agent_id, op_id);


SET search_path = omset, pg_catalog;

--
-- TOC entry 3335 (class 2606 OID 73855)
-- Dependencies: 645 645 3381
-- Name: bill_item_pkey; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill_item
    ADD CONSTRAINT bill_item_pkey PRIMARY KEY (id);


--
-- TOC entry 3329 (class 2606 OID 73819)
-- Dependencies: 641 641 3381
-- Name: bill_pkey; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill
    ADD CONSTRAINT bill_pkey PRIMARY KEY (id);


--
-- TOC entry 3327 (class 2606 OID 73787)
-- Dependencies: 639 639 3381
-- Name: objek_pajak_pkey; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY objek_pajak
    ADD CONSTRAINT objek_pajak_pkey PRIMARY KEY (id);


--
-- TOC entry 3331 (class 2606 OID 73845)
-- Dependencies: 643 643 3381
-- Name: op_item_pkey; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY op_item
    ADD CONSTRAINT op_item_pkey PRIMARY KEY (id);


--
-- TOC entry 3333 (class 2606 OID 73847)
-- Dependencies: 643 643 643 3381
-- Name: op_item_uq; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY op_item
    ADD CONSTRAINT op_item_uq UNIQUE (op_id, nama);


--
-- TOC entry 3337 (class 2606 OID 74018)
-- Dependencies: 647 647 3381
-- Name: wajib_pajak_pkey; Type: CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY wajib_pajak
    ADD CONSTRAINT wajib_pajak_pkey PRIMARY KEY (id);


SET search_path = app, pg_catalog;

--
-- TOC entry 3343 (class 2606 OID 50427)
-- Dependencies: 3316 358 289 3381
-- Name: group_modules_module_id_fkey; Type: FK CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY group_modules
    ADD CONSTRAINT group_modules_module_id_fkey FOREIGN KEY (module_id) REFERENCES modules(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 3342 (class 2606 OID 50432)
-- Dependencies: 3312 292 289 3381
-- Name: group_modules_user_id_fkey; Type: FK CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY group_modules
    ADD CONSTRAINT group_modules_user_id_fkey FOREIGN KEY (group_id) REFERENCES groups(id) MATCH FULL ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 3344 (class 2606 OID 50447)
-- Dependencies: 3304 204 358 3381
-- Name: modules_app_id_fkey; Type: FK CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY modules
    ADD CONSTRAINT modules_app_id_fkey FOREIGN KEY (app_id) REFERENCES apps(id);


--
-- TOC entry 3346 (class 2606 OID 50637)
-- Dependencies: 3312 292 605 3381
-- Name: user_groups_group_id_fkey; Type: FK CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY user_groups
    ADD CONSTRAINT user_groups_group_id_fkey FOREIGN KEY (group_id) REFERENCES groups(id);


--
-- TOC entry 3345 (class 2606 OID 50642)
-- Dependencies: 3322 612 605 3381
-- Name: user_groups_user_id_fkey; Type: FK CONSTRAINT; Schema: app; Owner: -
--

ALTER TABLE ONLY user_groups
    ADD CONSTRAINT user_groups_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id);


SET search_path = im, pg_catalog;

--
-- TOC entry 3351 (class 2606 OID 73937)
-- Dependencies: 3338 649 650 3381
-- Name: ts100_agent_id_fkey; Type: FK CONSTRAINT; Schema: im; Owner: -
--

ALTER TABLE ONLY ts100
    ADD CONSTRAINT ts100_agent_id_fkey FOREIGN KEY (agent_id) REFERENCES agent(id) ON DELETE CASCADE;


--
-- TOC entry 3352 (class 2606 OID 73942)
-- Dependencies: 3326 639 650 3381
-- Name: ts100_op_id_fkey; Type: FK CONSTRAINT; Schema: im; Owner: -
--

ALTER TABLE ONLY ts100
    ADD CONSTRAINT ts100_op_id_fkey FOREIGN KEY (op_id) REFERENCES omset.objek_pajak(id);


SET search_path = omset, pg_catalog;

--
-- TOC entry 3349 (class 2606 OID 73856)
-- Dependencies: 3328 641 645 3381
-- Name: bill_item_bill_id_fkey; Type: FK CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill_item
    ADD CONSTRAINT bill_item_bill_id_fkey FOREIGN KEY (bill_id) REFERENCES bill(id) ON DELETE CASCADE;


--
-- TOC entry 3350 (class 2606 OID 73861)
-- Dependencies: 3330 643 645 3381
-- Name: bill_item_op_item_id_fkey; Type: FK CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill_item
    ADD CONSTRAINT bill_item_op_item_id_fkey FOREIGN KEY (op_item_id) REFERENCES op_item(id);


--
-- TOC entry 3348 (class 2606 OID 74045)
-- Dependencies: 3326 639 641 3381
-- Name: bill_op_id_fkey; Type: FK CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY bill
    ADD CONSTRAINT bill_op_id_fkey FOREIGN KEY (op_id) REFERENCES objek_pajak(id);


--
-- TOC entry 3347 (class 2606 OID 74019)
-- Dependencies: 3336 647 639 3381
-- Name: objek_pajak_wp_id_fkey; Type: FK CONSTRAINT; Schema: omset; Owner: -
--

ALTER TABLE ONLY objek_pajak
    ADD CONSTRAINT objek_pajak_wp_id_fkey FOREIGN KEY (wp_id) REFERENCES wajib_pajak(id);


-- Completed on 2013-11-29 04:23:55

--
-- PostgreSQL database dump complete
--

