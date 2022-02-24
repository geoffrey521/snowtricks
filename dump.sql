--
-- PostgreSQL database dump
--

-- Dumped from database version 13.5
-- Dumped by pg_dump version 14.1 (Ubuntu 14.1-2.pgdg20.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.category (id, name) FROM stdin;
350	Grabs
351	Rail tricks
352	One foot tricks
353	Rotations
346	Grabs
347	Rail tricks
348	One foot tricks
349	Rotations
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public."user" (id, firstname, lastname, email, password, created_at, confirm_token, verified_at, reset_token, reset_at, remember_token, roles, agreed_terms_at, updated_at, username, is_active, avatar_url, avatar_path) FROM stdin;
525	Reva	Kertzmann	torp.wilburn@example.net	$2y$13$X8HoMAj8Nst8c5OYzfN47eh4T8WGkqdkmf.YsUFz.ExFlJMQYWHte	2022-02-24 01:07:53	\N	2021-12-29 08:49:46	\N	\N	\N	[]	2021-12-15 14:33:06	\N	thompson.rose	f	\N	\N
526	Joanie	Halvorson	fay.curtis@example.org	$2y$13$DQloeAWloLnQNmLxeEXZpOquYg.ve9FfFvuqtlEN.zYRorSoLozze	2022-02-24 01:07:53	\N	2022-01-02 04:03:29	\N	\N	\N	[]	2021-12-03 10:39:34	\N	becker.alvis	f	\N	\N
527	Tina	Ratke	kpfannerstill@example.net	$2y$13$Trpt7zeqFEJ5vQdZskeUd.bqdpdw5SJOvxG41eDZzPhKS.vRKICMO	2022-02-24 01:07:54	\N	2022-01-08 06:41:06	\N	\N	\N	[]	2021-12-04 23:56:02	\N	schneider.rubye	f	\N	\N
528	Leatha	Gleason	laurel79@example.org	$2y$13$WqeSMvOsUCgR15duoh6MWu.eJmBZz9nlw/O2uE5BdBL3q5JxlKRS.	2022-02-24 01:07:54	\N	2021-12-25 23:51:41	\N	\N	\N	[]	2021-12-09 23:21:58	\N	kunze.maurine	f	\N	\N
529	Alfredo	Tremblay	nyah75@example.org	$2y$13$FSnSSxkC9K2swzyveSFo4.gYp8fBTbzVNrCcstVVbLh2zDuY1nBgW	2022-02-24 01:07:54	\N	2021-12-27 13:18:47	\N	\N	\N	[]	2021-11-30 10:18:56	\N	easter.watsica	f	\N	\N
530	Eusebio	Cummerata	jasen.hammes@example.org	$2y$13$ZT6ukZSGcoAdi9IXIollgOP2yUNNOJHAEEHaiixeDKDyG9Jtnn/Wm	2022-02-24 01:07:55	\N	2022-01-16 03:30:42	\N	\N	\N	[]	2021-12-21 12:59:00	\N	sunny14	f	\N	\N
531	Leonie	Green	gschroeder@example.com	$2y$13$JDzE5ryj.49GX34dyD0.XOTTFcx64LzAqHwmv2ZhvKAieX6CS.z2W	2022-02-24 01:07:55	\N	2022-01-20 06:47:01	\N	\N	\N	[]	2021-12-09 05:38:17	\N	lora15	f	\N	\N
532	Hayley	Brakus	xfunk@example.com	$2y$13$P49Tg30oQtMOI852PUvhEOZhNunEkmheDBn/7GPASU2DueLCgURh6	2022-02-24 01:07:56	\N	2022-01-08 11:24:31	\N	\N	\N	[]	2021-11-25 07:18:10	\N	hlowe	f	\N	\N
533	Casandra	Nicolas	monique.hegmann@example.net	$2y$13$1bU7oY3DtHr1zyN5z8jpXOrc7LI7Ek/flDoLydlK76BaHINUYixyy	2022-02-24 01:07:56	\N	2022-01-08 08:15:42	\N	\N	\N	[]	2021-12-04 18:51:25	\N	federico51	f	\N	\N
534	Zetta	Kessler	legros.eryn@example.com	$2y$13$Fxpu2cKpEGY7uaQvpgCcNexGWAR.3kYWA417Gb/iKzSsZBqHO36CK	2022-02-24 01:07:56	\N	2021-12-31 02:12:17	\N	\N	\N	[]	2021-12-05 00:39:34	\N	cmcclure	f	\N	\N
535	Cedrick	Zemlak	admin@snowtricks.fr	$2y$13$ngy1dj1v0EAcqZe3TFNgoe43LEg2MCJW.OA8N6eOvVXD6c6RyCyye	2022-02-24 01:07:57	\N	2021-12-30 20:28:33	\N	\N	\N	["ROLE_ADMIN"]	2021-12-14 05:39:04	\N	admin	t	\N	\N
\.


--
-- Data for Name: trick; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.trick (id, name, description, created_at, updated_at, slug, author_id, category_id) FROM stdin;
4286	Melon	When you catch some snowboarding air, reach down and grab the heel side of the board between your feet. Congratulations, you’ve done your first Melon!	2022-02-24 01:17:05	\N	melon	535	346
4287	Front Flip	The frontflip is one of the easiest flips on the snowboard.\r\n1.\r\nBefore trying it out on the snow, practice the flip on a trampoline.\r\n2.\r\nAccelerate on a flat board. To get into a good spin, push onto the tail before the jump, and then quickly shift forward and push off with your front leg. Make sure your shoulders are parallel to the board.\r\n3.\r\nOnce in the air, draw up your knees and find your landing spot.\r\n4.\r\nLand your board flat.	2022-02-24 01:22:29	\N	front-flip	535	349
4288	Backside 360	A Backside 360 over a park jump is an awesome feeling trick! The Back 3 can be done with endless variations which allow your individual style to stand out and it's a key stepping stone onto harder, more advanced spins. If you're not quite ready for Back 3s on park jumps, check out this tutorial to build your skills:	2022-02-24 01:27:17	2022-02-24 01:31:35	backside-360	535	349
4289	Nose Grab	If you can do a Melon and Indy, you’re ready for a nose grab. While in the air, reach down to grab the front of your board. Straighten your body and prepare for an easy landing.	2022-02-24 01:43:58	\N	nose-grab	535	346
4290	Indy	You can perform an Indy by doing an Ollie off of a jump and reaching down to grab your board’s toe edge. Let go and reposition yourself for a smooth landing.	2022-02-24 01:47:11	\N	indy	535	346
4292	Corkscrew	Spins are corked or corkscrew when the axis of the spin allows for the snowboarder to be oriented sideways or upside-down in the air, typically without becoming completely inverted (though the head and shoulders should drop below the relative position of the board).  Peter Line is credited with originating the corked spin and first landing it on film in Transworld Snowboarding Video Magazine Vol 1.[4] A Double-Cork refers to a rotation in which a snowboarder inverts or orients themselves sideways at two distinct times during an aerial rotation. David Benedek is the originator of the Double-Cork in the Half-pipe, but the Double-Cork is also a very common trick in Big-Air competitions. Shaun White is known for making this trick famous in the half-pipe. Several snowboarders have recently extended the limits of technical snowboarding by performing triple-cork variations, Torstein Horgmo being the first to land one in competition. In 2011, Mark McMorris landed the first backside triple cork	2022-02-24 01:57:03	\N	corkscrew	535	349
4291	Tail Slide	Similar to a boardslide or lipslide, but only the tail of the board is on the feature. Proper tailslides are done with the feature directly under the back foot or farther out towards the tail.	2022-02-24 01:52:49	2022-02-24 01:57:37	tail-slide	535	347
4293	50-50	The 50-50 introduces you to snowboard slide tricks. When you approach a rail or box, jump to land on it and ride it until you come off at the other end. Start with short rails until you build the balance you need to ride longer ones.	2022-02-24 02:01:05	\N	50-50	535	347
4294	Tail Grab	The next time you catch some air, reach back to grab the tail of your snowboard.	2022-02-24 02:04:04	\N	tail-grab	535	346
4297	One-Foot Indy	Tricks performed with one foot removed from the binding (typically the rear foot) are referred to as one-footed tricks. One footed tricks include fast plants in which the rear foot is dropped and initiates a straight air or rotation, the boneless, which is a fast-plant with a grab; and the no-comply, which is a front-footed fast plant.	2022-02-24 02:32:58	\N	one-foot-indy	535	352
\.


--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.comment (id, trick_id, author_id, content, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20220103155244	2022-01-03 16:55:21	31
DoctrineMigrations\\Version20220103155822	2022-01-03 17:01:30	28
DoctrineMigrations\\Version20220103161332	2022-01-03 17:13:40	45
DoctrineMigrations\\Version20220103163901	2022-01-03 18:10:24	60
DoctrineMigrations\\Version20220103171030	2022-01-03 18:10:41	80
DoctrineMigrations\\Version20220103182654	2022-01-03 19:27:11	23
DoctrineMigrations\\Version20220104230733	2022-01-05 00:07:51	54
DoctrineMigrations\\Version20220105083530	2022-01-05 09:36:03	21
DoctrineMigrations\\Version20220107095924	2022-01-07 10:59:34	21
DoctrineMigrations\\Version20220107103527	2022-01-07 11:35:37	28
DoctrineMigrations\\Version20220111084029	2022-01-11 09:40:41	18
DoctrineMigrations\\Version20220111165643	2022-01-11 17:57:06	24
DoctrineMigrations\\Version20220111180908	2022-01-11 19:09:21	20
DoctrineMigrations\\Version20220112093227	2022-01-12 10:32:59	25
DoctrineMigrations\\Version20220112093634	2022-01-12 10:36:45	22
DoctrineMigrations\\Version20220114151305	2022-01-14 16:13:33	30
DoctrineMigrations\\Version20220118162455	2022-01-18 17:26:41	31
DoctrineMigrations\\Version20220118163513	2022-01-18 17:35:22	19
DoctrineMigrations\\Version20220131083642	2022-01-31 09:37:02	28
DoctrineMigrations\\Version20220131103003	2022-01-31 11:30:17	22
DoctrineMigrations\\Version20220202092630	2022-02-02 15:07:09	30
DoctrineMigrations\\Version20220207150416	2022-02-07 16:08:28	37
DoctrineMigrations\\Version20220207160924	2022-02-07 17:09:52	33
DoctrineMigrations\\Version20220215102850	2022-02-15 11:29:05	22
DoctrineMigrations\\Version20220216152316	2022-02-16 16:23:52	54
DoctrineMigrations\\Version20220217081035	2022-02-17 09:11:30	78
DoctrineMigrations\\Version20220222141034	2022-02-22 15:10:45	60
DoctrineMigrations\\Version20220222193757	2022-02-22 20:39:06	62
\.


--
-- Data for Name: image; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.image (id, title, caption, trick_id, path, promoted) FROM stdin;
15619	NickVisconti-PoleJamOneFoot-SaasFee-MattGEORGES-2560x1440-6216e04a40e6a.jpg	Image of the One-Foot Indy trick	4297	NickVisconti-PoleJamOneFoot-SaasFee-MattGEORGES-2560x1440-6216e04a40e6a.jpg	\N
15620	5fd0df838b71e479373918f01f686a6b-6216e0debb0f9.jpg	Image of the Tail Grab trick	4294	5fd0df838b71e479373918f01f686a6b-6216e0debb0f9.jpg	\N
15621	tail-grab-1-6216e0debb1f9.jpg	Image of the Tail Grab trick	4294	tail-grab-1-6216e0debb1f9.jpg	\N
15623	Women-Rail-Slide-6216e0f75fef5.jpg	Image of the 50-50 trick	4293	Women-Rail-Slide-6216e0f75fef5.jpg	t
15622	0-rZAsWY4zbJqIAoiW-6216e0f75fe0c.jpg	Image of the 50-50 trick	4293	0-rZAsWY4zbJqIAoiW-6216e0f75fe0c.jpg	f
15624	0b55f847977491ae985f882c28c06021-6216e11385bb7.jpg	Image of the Corkscrew trick	4292	0b55f847977491ae985f882c28c06021-6216e11385bb7.jpg	\N
15625	billy-morgan-quad-cork-snowboard-6216e11385caf.jpg	Image of the Corkscrew trick	4292	billy-morgan-quad-cork-snowboard-6216e11385caf.jpg	\N
15626	Frontside-tailslide-6216e12c8d781.jpg	Image of the Tail Slide trick	4291	Frontside-tailslide-6216e12c8d781.jpg	\N
15627	tailslide-6216e12c8d874.jpg	Image of the Tail Slide trick	4291	tailslide-6216e12c8d874.jpg	\N
15629	snowboarder-indy-grab-chamonix-france-pierre-leclerc-photography-6216e154c5a5f.jpg	Image of the Indy trick	4290	snowboarder-indy-grab-chamonix-france-pierre-leclerc-photography-6216e154c5a5f.jpg	t
15628	indy-6216e154c596b.jpg	Image of the Indy trick	4290	indy-6216e154c596b.jpg	f
15630	buck-hill-ski-snowboard-6216e16eb4555.jpg	Image of the Nose Grab trick	4289	buck-hill-ski-snowboard-6216e16eb4555.jpg	\N
15631	nosegrab-6216e16eb464d.jpg	Image of the Nose Grab trick	4289	nosegrab-6216e16eb464d.jpg	\N
15632	nosegrab2-6216e16eb46c2.jpg	Image of the Nose Grab trick	4289	nosegrab2-6216e16eb46c2.jpg	\N
15633	2-Ben-Bs360TailGrab-620x413-6216e192c7f34.jpg	Image of the Backside 360 trick	4288	2-Ben-Bs360TailGrab-620x413-6216e192c7f34.jpg	\N
15634	Whitelines-94-b-s-360-tail-620x274-6216e192c801c.jpg	Image of the Backside 360 trick	4288	Whitelines-94-b-s-360-tail-620x274-6216e192c801c.jpg	\N
15636	frontflip-6216e1ac662a8.jpg	Image of the Front Flip trick	4287	frontflip-6216e1ac662a8.jpg	\N
15637	IMG-7636-620x413-6216e1ac6637d.jpg	Image of the Front Flip trick	4287	IMG-7636-620x413-6216e1ac6637d.jpg	t
15635	Barry-from-Real-Snowboarding-doing-a-side-hit-front-flip-6216e1ac66175.jpg	Image of the Front Flip trick	4287	Barry-from-Real-Snowboarding-doing-a-side-hit-front-flip-6216e1ac66175.jpg	f
15639	melon2-6216e1ca8091b.jpg	Image of the Melon trick	4286	melon2-6216e1ca8091b.jpg	t
15638	melon1-6216e1ca80834.jpg	Image of the Melon trick	4286	melon1-6216e1ca80834.jpg	f
\.


--
-- Data for Name: reset_password_request; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) FROM stdin;
\.


--
-- Data for Name: video; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.video (id, trick_id, url, thumbnail) FROM stdin;
7476	4286	https://www.youtube.com/embed/OMxJRz06Ujc	https://img.youtube.com/vi/OMxJRz06Ujc/0.jpg
7477	4286	https://www.youtube.com/embed/4h4cB1Kkc2s	https://img.youtube.com/vi/4h4cB1Kkc2s/0.jpg
7478	4287	https://www.youtube.com/embed/eGJ8keB1-JM	https://img.youtube.com/vi/eGJ8keB1-JM/0.jpg
7479	4287	https://www.youtube.com/embed/xhvqu2XBvI0	https://img.youtube.com/vi/xhvqu2XBvI0/0.jpg
7480	4287	https://www.youtube.com/embed/aTTkQ45DUfk	https://img.youtube.com/vi/aTTkQ45DUfk/0.jpg
7481	4288	https://www.youtube.com/embed/hUQ3eKS13co	https://img.youtube.com/vi/hUQ3eKS13co/0.jpg
7482	4289	https://www.youtube.com/embed/mfm3a3og3LI	https://img.youtube.com/vi/mfm3a3og3LI/0.jpg
7483	4289	https://www.youtube.com/embed/nIS14rVlbyQ	https://img.youtube.com/vi/nIS14rVlbyQ/0.jpg
7484	4290	https://www.youtube.com/embed/6yA3XqjTh_w	https://img.youtube.com/vi/6yA3XqjTh_w/0.jpg
7485	4290	https://www.youtube.com/embed/FracN6hoD7c	https://img.youtube.com/vi/FracN6hoD7c/0.jpg
7486	4291	https://www.youtube.com/embed/HRNXjMBakwM	https://img.youtube.com/vi/HRNXjMBakwM/0.jpg
7487	4291	https://www.youtube.com/embed/KqSi94FT7EE	https://img.youtube.com/vi/KqSi94FT7EE/0.jpg
7488	4292	https://www.youtube.com/embed/FMHiSF0rHF8	https://img.youtube.com/vi/FMHiSF0rHF8/0.jpg
7489	4292	https://www.youtube.com/embed/P5ZI-d-eHsI	https://img.youtube.com/vi/P5ZI-d-eHsI/0.jpg
7490	4293	https://www.youtube.com/embed/e-7NgSu9SXg	https://img.youtube.com/vi/e-7NgSu9SXg/0.jpg
7491	4294	https://www.youtube.com/embed/_Qq-YoXwNQY	https://img.youtube.com/vi/_Qq-YoXwNQY/0.jpg
7492	4294	https://www.youtube.com/embed/gbjwHZDaJLE	https://img.youtube.com/vi/gbjwHZDaJLE/0.jpg
7493	4294	https://www.youtube.com/embed/lVMp6nIWhIg	https://img.youtube.com/vi/lVMp6nIWhIg/0.jpg
7497	4297	https://www.youtube.com/embed/LWUfrwCofuA	https://img.youtube.com/vi/LWUfrwCofuA/0.jpg
7498	4297	https://www.youtube.com/embed/4IVdWdvsrVA	https://img.youtube.com/vi/4IVdWdvsrVA/0.jpg
\.


--
-- Name: category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.category_id_seq', 349, true);


--
-- Name: comment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.comment_id_seq', 20075, true);


--
-- Name: image_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.image_id_seq', 15639, true);


--
-- Name: reset_password_request_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.reset_password_request_id_seq', 1, false);


--
-- Name: trick_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.trick_id_seq', 4297, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.user_id_seq', 535, true);


--
-- Name: video_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.video_id_seq', 7498, true);


--
-- PostgreSQL database dump complete
--

