--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.1.9
-- Started on 2013-11-28 23:46:56

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = omset, pg_catalog;

--
-- TOC entry 3265 (class 0 OID 73811)
-- Dependencies: 641 3266
-- Data for Name: bill; Type: TABLE DATA; Schema: omset; Owner: postgres
--

INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201334968, '2013-01-16 00:00:00+07', 97040702, 1571200, 7, 'AG005', 'IMPORT FROM', '2013-01-16 00:00:00+07', '2013-01-16 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201335016, '2013-01-14 00:00:00+07', 96020402, 16212585, 7, 'AG006', 'IMPORT FROM', '2013-01-14 00:00:00+07', '2013-01-14 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201335032, '2013-01-14 00:00:00+07', 94020202, 44164818, 7, 'AG008', 'IMPORT FROM', '2013-01-14 00:00:00+07', '2013-01-14 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201335020, '2013-01-15 00:00:00+07', 93010502, 1097420, 7, 'AG009', 'IMPORT FROM', '2013-01-15 00:00:00+07', '2013-01-15 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201332729, '2013-01-11 00:00:00+07', 100030302, 12553364, 7, 'AG002', 'IMPORT FROM', '2013-01-11 00:00:00+07', '2013-01-11 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201332826, '2013-01-15 00:00:00+07', 102030302, 5353400, 7, 'AG001', 'IMPORT FROM', '2013-01-15 00:00:00+07', '2013-01-15 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201332906, '2013-01-10 00:00:00+07', 92010502, 25786472, 7, 'AG010', 'IMPORT FROM', '2013-01-10 00:00:00+07', '2013-01-10 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201335892, '2013-01-11 00:00:00+07', 98010502, 9882125, 7, 'AG004', 'IMPORT FROM', '2013-01-11 00:00:00+07', '2013-01-11 00:00:00+07', '');
INSERT INTO bill (id, tgl, op_id, nominal, jalur_id, agent_id, ket_pengirim, tgl_kirim, tgl_kwitansi, no_kwitansi) VALUES (201337407, '2013-01-15 00:00:00+07', 93010502, 1000440, 7, 'AG009', 'IMPORT FROM', '2013-01-15 00:00:00+07', '2013-01-15 00:00:00+07', '');


--
-- TOC entry 3270 (class 0 OID 0)
-- Dependencies: 640
-- Name: bill_id_seq; Type: SEQUENCE SET; Schema: omset; Owner: postgres
--

SELECT pg_catalog.setval('bill_id_seq', 4, true);


-- Completed on 2013-11-28 23:46:56

--
-- PostgreSQL database dump complete
--

