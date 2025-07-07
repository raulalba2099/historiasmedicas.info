-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2023 a las 07:33:40
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consultorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cit_id` int(11) NOT NULL,
  `cit_pac_id` int(11) NOT NULL,
  `cit_fecha` date NOT NULL,
  `cit_hora` time DEFAULT NULL,
  `cit_consulta` int(11) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`cit_id`, `cit_pac_id`, `cit_fecha`, `cit_hora`, `cit_consulta`, `updated_at`, `created_at`) VALUES
(113, 1, '2023-04-08', '09:00:00', 0, '2023-04-08 21:10:52', '2023-04-08 21:10:52'),
(114, 3, '2023-04-08', '09:30:00', 0, '2023-04-08 21:11:04', '2023-04-08 21:11:04'),
(115, 2, '2023-04-08', '10:00:00', 0, '2023-04-08 21:11:20', '2023-04-08 21:11:20'),
(116, 1, '2023-04-16', '09:00:00', 0, '2023-04-16 20:50:07', '2023-04-16 20:50:07'),
(119, 5, '2023-05-20', '09:00:00', 0, '2023-05-21 05:08:30', '2023-05-21 05:08:02'),
(120, 1, '2023-05-27', '18:00:00', 0, '2023-05-28 23:38:32', '2023-05-28 23:38:32'),
(121, 1, '2023-05-26', '18:00:00', 0, '2023-05-30 03:56:15', '2023-05-28 23:40:21'),
(122, 1, '2023-05-26', '17:00:00', 0, '2023-05-30 03:56:08', '2023-05-28 23:54:29'),
(123, 1, '2023-05-26', '09:00:00', 0, '2023-05-28 23:56:45', '2023-05-28 23:56:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `con_id` int(11) NOT NULL,
  `con_cit_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios`
--

CREATE TABLE `estudios` (
  `est_id` bigint(20) NOT NULL,
  `est_pac_id` bigint(20) NOT NULL,
  `est_nombre` varchar(255) NOT NULL,
  `est_observaciones` text DEFAULT NULL,
  `est_archivo` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `est_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estudios`
--

INSERT INTO `estudios` (`est_id`, `est_pac_id`, `est_nombre`, `est_observaciones`, `est_archivo`, `remember_token`, `created_at`, `updated_at`, `est_fecha`) VALUES
(1, 1, 'Quimica Sanguinea', 'd', 'public/files/estudios/est_1_64379ed656cc5.pdf', NULL, '2023-04-13 06:19:02', '2023-04-13 06:19:02', '2023-04-13'),
(2, 1, 'Biometría Hematica', NULL, 'public/files/estudios/est_1_643c5fc88e6fb.pdf', NULL, '2023-04-16 20:51:20', '2023-04-16 20:51:20', '2023-04-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_fisico`
--

CREATE TABLE `examen_fisico` (
  `id` int(11) NOT NULL,
  `exa_cit_id` int(11) NOT NULL,
  `exa_pac_id` int(11) NOT NULL,
  `frecuencia_cardiaca` varchar(10) DEFAULT NULL,
  `frecuencia_respiratoria` varchar(10) DEFAULT NULL,
  `presion_arterial` varchar(10) DEFAULT NULL,
  `temperatura` varchar(10) DEFAULT NULL,
  `talla` double DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `imc` double DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examen_fisico`
--

INSERT INTO `examen_fisico` (`id`, `exa_cit_id`, `exa_pac_id`, `frecuencia_cardiaca`, `frecuencia_respiratoria`, `presion_arterial`, `temperatura`, `talla`, `peso`, `imc`, `diagnostico`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 113, 1, '75', '93', '120-60', '36', 77, 90, 13, 'Covid', '2023-04-16', '2023-05-28 23:10:45', '2023-04-16 19:03:43'),
(3, 116, 1, '80', '90', '120-80', '35', 1.74, 92, 123, 'Amigtdalitis', '2023-05-28', '2023-05-28 23:12:50', '2023-05-28 18:21:00'),
(4, 120, 1, '1', '2', '3', '4', 6, 5, 7, '8', '2023-05-27', '2023-05-28 23:39:24', '2023-05-28 23:38:47'),
(5, 121, 1, '2', '2', '2', '2', 2, 2, 2, '2', '2023-05-24', '2023-05-28 23:53:54', '2023-05-28 23:41:45'),
(6, 122, 1, '3', '3', '3', '3', 3, 3, 3, '3', '2023-05-25', '2023-05-28 23:56:24', '2023-05-28 23:56:24'),
(7, 123, 1, '4', '4', '4', '4', 4, 4, 4, '4', '2023-05-26', '2023-05-28 23:56:55', '2023-05-28 23:56:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica`
--

CREATE TABLE `historia_clinica` (
  `his_id` int(11) NOT NULL,
  `his_pac_id` int(11) NOT NULL,
  `his_pre_id` int(11) NOT NULL,
  `his_respuesta` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica_preguntas`
--

CREATE TABLE `historia_clinica_preguntas` (
  `id` int(11) NOT NULL,
  `id_subseccion` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `id_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_clinica_preguntas`
--

INSERT INTO `historia_clinica_preguntas` (`id`, `id_subseccion`, `descripcion`, `tipo`, `estado`, `updated_at`, `created_at`, `orden`, `id_padre`) VALUES
(1, 1, '1.-', 1, 1, '2023-04-26 03:29:52', '2023-04-26 03:29:52', 1, NULL),
(2, 1, '2.-', 1, 1, '2023-04-26 03:42:18', '2023-04-26 03:42:18', 2, NULL),
(3, 1, '3.-', 1, 1, '2023-04-26 03:43:00', '2023-04-26 03:43:00', 3, NULL),
(5, 2, '3.-', 1, 1, '2023-05-27 06:28:26', '2023-04-26 03:52:33', 3, NULL),
(6, 2, '1.-', 1, 1, '2023-04-26 03:55:52', '2023-04-26 03:55:52', 1, NULL),
(7, 2, '2.-', 1, 1, '2023-04-26 03:59:13', '2023-04-26 03:59:13', 2, NULL),
(9, 3, '1.-', 1, 1, '2023-05-04 04:08:37', '2023-05-04 04:07:18', 1, NULL),
(10, 3, '2.-', 1, 1, '2023-05-04 04:08:53', '2023-05-04 04:07:57', 2, NULL),
(11, 4, 'Hepatitis B', 3, 1, '2023-05-06 17:18:53', '2023-05-06 02:13:47', 1, NULL),
(12, 4, 'Hepatitis C', 3, 1, '2023-05-06 02:14:10', '2023-05-06 02:14:10', 2, NULL),
(13, 4, 'VIH', 3, 1, '2023-05-06 02:15:09', '2023-05-06 02:15:09', 3, NULL),
(14, 4, 'Año', 1, 2, '2023-05-06 03:50:34', '2023-05-06 03:45:16', 4, 12),
(15, 4, 'año', 1, 2, '2023-05-06 03:50:52', '2023-05-06 03:50:52', 6, 13),
(16, 5, '1.-', 1, 1, '2023-05-06 03:52:15', '2023-05-06 03:52:15', 1, NULL),
(17, 5, '2.-', 1, 1, '2023-05-06 03:52:27', '2023-05-06 03:52:27', 2, NULL),
(18, 5, '3.-', 1, 1, '2023-05-06 03:53:20', '2023-05-06 03:53:20', 3, NULL),
(19, 5, '4.-', 1, 1, '2023-05-06 03:54:05', '2023-05-06 03:54:05', 4, NULL),
(20, 6, 'Fumador', 3, 1, '2023-05-07 01:49:08', '2023-05-07 01:49:08', 1, NULL),
(21, 6, 'Bebedor', 3, 1, '2023-05-07 01:49:24', '2023-05-07 01:49:24', 2, NULL),
(22, 6, '¿Usa alguna sustancia como cocaína o marihuana?', 1, 1, '2023-05-07 01:50:06', '2023-05-07 01:50:06', 3, NULL),
(23, 7, 'Fiebres recurrentes', 3, 1, '2023-05-07 02:56:23', '2023-05-07 02:56:23', 0, NULL),
(24, 7, 'Pérdida de peso', 3, 1, '2023-05-07 02:56:42', '2023-05-07 02:56:42', 2, NULL),
(25, 7, 'Cansancio todo el tiempo', 3, 1, '2023-05-07 02:57:01', '2023-05-07 02:57:01', 3, NULL),
(26, 7, 'Debilidad en todo el cuerpo', 3, 1, '2023-05-07 02:57:34', '2023-05-07 02:57:34', 4, NULL),
(27, 7, 'Intolerancia al frio/calor', 3, 1, '2023-05-07 02:59:43', '2023-05-07 02:59:43', 5, NULL),
(28, 9, 'Enfermedad de la tiroides', 3, 1, '2023-05-07 03:01:34', '2023-05-07 03:01:34', 1, NULL),
(29, 9, 'Cambio de la talla de sombrero', 3, 1, '2023-05-07 03:02:17', '2023-05-07 03:02:17', 2, NULL),
(30, 10, 'Cambios de pigmentación', 3, 1, '2023-05-07 03:03:19', '2023-05-07 03:03:19', 1, NULL),
(31, 10, 'Soriasis', 3, 1, '2023-05-07 03:03:50', '2023-05-07 03:03:50', 2, NULL),
(32, 10, 'Erupciones cutáneas recurrentes', 3, 1, '2023-05-07 03:04:21', '2023-05-07 03:04:21', 3, NULL),
(33, 10, 'Picazón frecuente', 3, 1, '2023-05-07 03:04:41', '2023-05-07 03:04:41', 4, NULL),
(34, 10, 'Exposición breve al sol que causa erupciones cutáneas', 3, 1, '2023-05-07 03:22:26', '2023-05-07 03:22:26', 5, NULL),
(35, 10, 'Cambios recientes de las uñas de las manos y de los pies', 3, 1, '2023-05-07 03:22:53', '2023-05-07 03:22:53', 6, NULL),
(36, 10, 'Los puntos de los dedos pierden el color cuando hace frio', 3, 1, '2023-05-07 03:24:24', '2023-05-07 03:24:24', 7, NULL),
(37, 10, 'Pérdida significativa de cabello', 3, 1, '2023-05-07 03:24:48', '2023-05-07 03:24:48', 7, NULL),
(38, 11, 'Resequedad crónica en la boca', 3, 1, '2023-05-07 03:32:43', '2023-05-07 03:32:43', 1, NULL),
(39, 11, 'Frecuentes úlceras en la boca', 3, 1, '2023-05-07 03:33:00', '2023-05-07 03:33:00', 2, NULL),
(40, 11, 'Ronquera crónica', 3, 1, '2023-05-07 03:33:19', '2023-05-07 03:33:19', 3, NULL),
(41, 11, 'Pérdida de la Audición', 3, 1, '2023-05-07 03:33:33', '2023-05-07 03:33:33', 4, NULL),
(42, 6, '¿Usa alguna sustancia como cocaína o marihuana? DOS', 1, 1, '2023-05-17 03:52:06', '2023-05-17 03:52:06', 4, NULL),
(43, 12, 'Osteoartritis', 2, 1, '2023-05-27 03:59:31', '2023-05-19 02:24:30', 1, NULL),
(44, 12, 'Osteoporosis', 2, 1, '2023-05-27 03:59:46', '2023-05-19 02:25:13', 2, NULL),
(45, 12, 'Influenza', 2, 2, '2023-05-19 02:25:44', '2023-05-19 02:25:44', 3, NULL),
(46, 12, 'Exavalente', 2, 2, '2023-05-19 02:28:32', '2023-05-19 02:28:32', 4, NULL),
(47, 12, 'Pentavalente', 2, 2, '2023-05-19 02:30:45', '2023-05-19 02:30:45', 5, NULL),
(48, 12, 'Hepatitis', 2, 2, '2023-05-19 02:33:22', '2023-05-19 02:33:22', 6, NULL),
(50, 12, 'Artritis reumatoide', 2, 1, '2023-05-27 03:48:10', '2023-05-27 03:48:10', 1, NULL),
(51, 12, 'Lupus', 2, 1, '2023-05-27 03:48:31', '2023-05-27 03:48:31', 1, NULL),
(52, 12, 'Fibromialgia', 2, 1, '2023-05-27 03:49:21', '2023-05-27 03:49:21', 2, NULL),
(53, 12, 'Gota', 2, 1, '2023-05-27 03:50:09', '2023-05-27 03:50:09', 4, NULL),
(55, 12, 'Soriasis', 2, 1, '2023-05-27 03:59:15', '2023-05-27 03:56:14', 4, NULL),
(56, 15, 'Diabetes', 2, 1, '2023-05-27 04:00:28', '2023-05-27 04:00:28', 1, NULL),
(57, 15, 'Soriasis', 2, 1, '2023-05-27 04:00:46', '2023-05-27 04:00:46', 2, NULL),
(58, 15, 'Enfermedad de Crohn’s', 2, 1, '2023-05-27 04:01:07', '2023-05-27 04:01:07', 3, NULL),
(59, 15, 'Espondilitis anquilosante', 2, 1, '2023-05-27 04:01:37', '2023-05-27 04:01:37', 4, NULL),
(60, 15, 'Presión sanguínea elevada', 2, 1, '2023-05-27 04:02:06', '2023-05-27 04:02:06', 5, NULL),
(62, 17, '1.-', 1, 1, '2023-05-27 04:18:17', '2023-05-27 04:18:17', 0, NULL),
(63, 17, '2.-', 1, 1, '2023-05-27 04:18:28', '2023-05-27 04:18:28', 2, NULL),
(64, 17, '3.-', 1, 1, '2023-05-27 04:18:47', '2023-05-27 04:18:47', 3, NULL),
(65, 17, '4.-', 1, 1, '2023-05-27 04:19:04', '2023-05-27 04:19:04', 4, NULL),
(66, 17, '5.-', 1, 1, '2023-05-27 04:19:43', '2023-05-27 04:19:43', 5, NULL),
(67, 18, '1.-', 1, 1, '2023-05-27 04:21:01', '2023-05-27 04:21:01', 1, NULL),
(68, 18, '2.-', 1, 1, '2023-05-27 04:21:12', '2023-05-27 04:21:12', 2, NULL),
(69, 18, '3.-', 1, 1, '2023-05-27 04:21:28', '2023-05-27 04:21:28', 3, NULL),
(70, 8, 'Dolor por todo el cuerpo (músculos/articulaciones)', 1, 1, '2023-05-27 05:28:09', '2023-05-27 05:25:06', 1, NULL),
(71, 8, 'Dolor en las articulaciones. ¿Cuáles?', 1, 1, '2023-05-27 05:28:32', '2023-05-27 05:25:42', 2, NULL),
(72, 8, 'Dolores musculares. ¿Dónde?', 1, 1, '2023-05-27 05:28:52', '2023-05-27 05:25:56', 3, NULL),
(73, 8, 'Rigidez corporal al despertarse. ¿Cuánto tiempo le dura?', 1, 1, '2023-05-27 05:29:20', '2023-05-27 05:29:20', 4, NULL),
(74, 8, 'Inflamación en las articulaciones. ¿Cuáles?', 1, 1, '2023-05-27 05:29:40', '2023-05-27 05:29:40', 5, NULL),
(75, 8, 'Los dedos de las manos o los pies se inflaman tanto que parecen salchichas', 1, 1, '2023-05-27 05:30:07', '2023-05-27 05:30:07', 6, NULL),
(76, 19, 'Resequedad crónica en la boca', 3, 1, '2023-05-27 05:33:13', '2023-05-27 05:33:13', 1, NULL),
(77, 19, 'Frecuentes úlceras en la boca', 3, 1, '2023-05-27 05:33:30', '2023-05-27 05:33:30', 2, NULL),
(78, 19, 'Ronquera crónica', 3, 1, '2023-05-27 05:33:46', '2023-05-27 05:33:46', 3, NULL),
(79, 19, 'Pérdida de la Audición', 3, 1, '2023-05-27 05:34:01', '2023-05-27 05:34:01', 4, NULL),
(80, 20, 'El pecho le duele cuando respira profundo', 3, 1, '2023-05-27 05:37:52', '2023-05-27 05:37:52', 1, NULL),
(81, 20, 'Siente que le falta la respiración frecuentemente', 3, 1, '2023-05-27 05:38:08', '2023-05-27 05:38:08', 2, NULL),
(82, 20, 'Tos frecuente', 3, 1, '2023-05-27 05:38:35', '2023-05-27 05:38:35', 3, NULL),
(83, 20, 'Sibilancia frecuente', 3, 1, '2023-05-27 05:38:54', '2023-05-27 05:38:54', 4, NULL),
(84, 20, 'Ronquidos', 2, 1, '2023-05-27 05:39:14', '2023-05-27 05:39:14', 5, NULL),
(85, 20, 'Pulmonía recurrente', 3, 1, '2023-05-27 05:40:06', '2023-05-27 05:40:06', 6, NULL),
(86, 20, 'Asma', 3, 1, '2023-05-27 05:40:56', '2023-05-27 05:40:56', 7, NULL),
(87, 21, 'Inflamación frecuente de los ganglios', 3, 1, '2023-05-27 05:44:05', '2023-05-27 05:44:05', 1, NULL),
(88, 21, 'Ha recibido tratamiento para coágulos de sangre. ¿En qué parte del cuerpo?', 1, 1, '2023-05-27 05:44:30', '2023-05-27 05:44:30', 2, NULL),
(89, 21, 'Sangrado excesivo', 3, 1, '2023-05-27 05:44:45', '2023-05-27 05:44:45', 3, NULL),
(90, 21, 'Frecuente sangrado nasal', 3, 1, '2023-05-27 05:45:40', '2023-05-27 05:45:40', 4, NULL),
(91, 21, 'Moretones en exceso', 3, 1, '2023-05-27 05:45:56', '2023-05-27 05:45:56', 5, NULL),
(92, 22, 'Dolores de cabeza', 3, 1, '2023-05-27 05:46:58', '2023-05-27 05:46:58', 1, NULL),
(93, 22, 'Convulsiones', 3, 1, '2023-05-27 05:50:02', '2023-05-27 05:47:18', 2, NULL),
(94, 22, 'Entumecimiento. ¿Cuál(es) parte(s) del cuerpo?', 1, 1, '2023-05-27 05:50:26', '2023-05-27 05:47:41', 3, NULL),
(95, 22, 'Ardor. ¿Cuál(es) parte(s) del cuerpo?', 1, 1, '2023-05-27 05:51:39', '2023-05-27 05:48:09', 4, NULL),
(96, 22, 'Sensación de Hormigueo. ¿Cuál(es) parte(s) del cuerpo?', 1, 1, '2023-05-27 05:50:50', '2023-05-27 05:48:30', 5, NULL),
(97, 22, 'Debilidad reciente en alguna parte del cuerpo', 1, 1, '2023-05-27 05:51:01', '2023-05-27 05:48:43', 6, NULL),
(98, 23, 'Depresión', 3, 1, '2023-05-27 05:52:14', '2023-05-27 05:52:14', 1, NULL),
(99, 23, 'Trastornos de sueño', 3, 1, '2023-05-27 05:52:32', '2023-05-27 05:52:32', 2, NULL),
(100, 23, 'Problemas para dormirse', 3, 1, '2023-05-27 05:53:03', '2023-05-27 05:53:03', 3, NULL),
(101, 23, 'Problemas para mantenerse despierto', 3, 1, '2023-05-27 05:53:34', '2023-05-27 05:53:34', 4, NULL),
(102, 23, 'Ansiedad', 3, 1, '2023-05-27 05:54:19', '2023-05-27 05:54:19', 4, NULL),
(103, 23, 'Confusión', 3, 1, '2023-05-27 05:54:37', '2023-05-27 05:54:37', 5, NULL),
(104, 24, 'Número de veces que ha estado embarazada', 1, 1, '2023-05-27 05:55:19', '2023-05-27 05:55:19', 1, NULL),
(105, 24, 'Número de hijos nacidos vivos', 1, 1, '2023-05-27 05:55:46', '2023-05-27 05:55:46', 2, NULL),
(106, 24, 'Número de pérdidas', 1, 1, '2023-05-27 05:56:00', '2023-05-27 05:56:00', 3, NULL),
(107, 24, 'Número de abortos', 1, 1, '2023-05-27 05:56:11', '2023-05-27 05:56:11', 4, NULL),
(108, 24, 'Método anticonceptivo', 1, 1, '2023-05-27 05:56:26', '2023-05-27 05:56:26', 5, NULL),
(109, 25, 'Dolor en el pecho cuando se esfuerza', 3, 1, '2023-05-27 06:07:16', '2023-05-27 06:07:16', 1, NULL),
(110, 25, 'Esforzarse levemente resulta en una falta de aire', 3, 1, '2023-05-27 06:07:30', '2023-05-27 06:07:30', 2, NULL),
(111, 25, 'Desmayos recientes', 3, 1, '2023-05-27 06:07:46', '2023-05-27 06:07:46', 3, NULL),
(112, 25, 'Inflamación frecuente de los tobillos', 3, 1, '2023-05-27 06:08:02', '2023-05-27 06:08:02', 4, NULL),
(113, 26, 'Acidez', 3, 1, '2023-05-27 06:09:55', '2023-05-27 06:09:55', 1, NULL),
(114, 26, 'Náusea frecuente', 3, 1, '2023-05-27 06:10:11', '2023-05-27 06:10:11', 2, NULL),
(115, 26, 'Enfermedad de Crohn/Colitis ulcerativa', 3, 1, '2023-05-27 06:10:47', '2023-05-27 06:10:47', 3, NULL),
(116, 26, 'Síndrome del intestino irritable', 3, 1, '2023-05-27 06:11:06', '2023-05-27 06:11:06', 4, NULL),
(117, 26, 'Sangre en la heces o heces negras/alquitranadas', 3, 1, '2023-05-27 06:11:38', '2023-05-27 06:11:38', 5, NULL),
(118, 27, 'Dolor al orinar', 3, 1, '2023-05-27 06:12:33', '2023-05-27 06:12:33', 1, NULL),
(119, 27, 'Sangre en la orina', 3, 1, '2023-05-27 06:13:04', '2023-05-27 06:13:04', 2, NULL),
(120, 27, 'Cálculos en los riñones', 3, 1, '2023-05-27 06:13:26', '2023-05-27 06:13:26', 3, NULL),
(121, 27, 'Infecciones frecuentes de la vejiga', 3, 1, '2023-05-27 06:13:49', '2023-05-27 06:13:49', 4, NULL),
(122, 27, 'Úlceras genitales frecuentes', 3, 1, '2023-05-27 06:14:05', '2023-05-27 06:14:05', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica_respuestas`
--

CREATE TABLE `historia_clinica_respuestas` (
  `res_id` int(11) NOT NULL,
  `res_pac_id` int(11) NOT NULL,
  `res_pre_id` int(11) NOT NULL,
  `res_respuesta` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_clinica_respuestas`
--

INSERT INTO `historia_clinica_respuestas` (`res_id`, `res_pac_id`, `res_pre_id`, `res_respuesta`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Problemas medicos actuales 1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(2, 1, 2, 'Problemas medicos actuales 2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(3, 1, 3, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(4, 1, 6, 'Facturas 1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(5, 1, 7, 'f2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(6, 1, 5, 'f3', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(7, 1, 9, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(8, 1, 10, 'l2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(9, 1, 16, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(10, 1, 17, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(11, 1, 18, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(12, 1, 19, 'c4', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(13, 1, 22, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(14, 1, 42, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(15, 1, 23, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(16, 1, 11, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(17, 1, 20, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(18, 1, 28, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(19, 1, 30, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(20, 1, 38, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(21, 1, 12, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(22, 1, 21, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(23, 1, 24, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(24, 1, 29, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(25, 1, 31, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(26, 1, 39, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(27, 1, 13, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(28, 1, 25, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(29, 1, 32, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(30, 1, 40, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(31, 1, 26, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(32, 1, 33, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(33, 1, 41, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(34, 1, 27, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(35, 1, 34, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(36, 1, 35, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(37, 1, 36, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(38, 1, 37, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(39, 1, 43, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(40, 1, 44, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(41, 1, 45, '2', '2023-05-19 03:35:52', '2023-05-19 03:35:52'),
(42, 1, 46, '2', '2023-05-19 03:35:52', '2023-05-19 03:35:52'),
(43, 1, 47, '1', '2023-05-19 03:35:52', '2023-05-19 03:35:52'),
(44, 1, 48, '1', '2023-05-19 03:35:52', '2023-05-19 03:35:52'),
(45, 1, 62, 'Paracetamol', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(46, 1, 63, 'Metamizol Sodico', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(47, 1, 64, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(48, 1, 65, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(49, 1, 66, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(50, 1, 67, 'Ampicilina', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(51, 1, 68, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(52, 1, 69, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(53, 1, 50, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(54, 1, 51, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(55, 1, 56, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(56, 1, 52, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(57, 1, 57, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(58, 1, 58, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(59, 1, 53, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(60, 1, 55, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(61, 1, 59, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(62, 1, 60, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(63, 1, 70, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(64, 1, 71, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(65, 1, 72, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(66, 1, 73, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(67, 1, 74, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(68, 1, 75, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(69, 1, 88, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(70, 1, 94, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(71, 1, 95, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(72, 1, 96, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(73, 1, 97, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(74, 1, 104, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(75, 1, 105, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(76, 1, 106, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(77, 1, 107, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(78, 1, 108, 'DIU', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(79, 1, 76, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(80, 1, 80, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(81, 1, 87, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(82, 1, 92, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(83, 1, 98, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(84, 1, 109, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(85, 1, 113, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(86, 1, 118, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(87, 1, 77, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(88, 1, 81, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(89, 1, 93, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(90, 1, 99, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(91, 1, 110, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(92, 1, 114, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(93, 1, 119, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(94, 1, 78, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(95, 1, 82, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(96, 1, 89, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(97, 1, 100, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(98, 1, 111, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(99, 1, 115, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(100, 1, 120, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(101, 1, 79, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(102, 1, 83, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(103, 1, 90, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(104, 1, 101, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(105, 1, 102, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(106, 1, 112, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(107, 1, 116, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(108, 1, 121, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(109, 1, 91, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(110, 1, 103, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(111, 1, 117, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(112, 1, 85, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(113, 1, 122, NULL, '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(114, 1, 86, '1', '2023-05-27 06:21:33', '2023-05-27 06:21:33'),
(115, 1, 84, '2', '2023-05-27 06:21:33', '2023-05-27 06:21:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica_secciones`
--

CREATE TABLE `historia_clinica_secciones` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_clinica_secciones`
--

INSERT INTO `historia_clinica_secciones` (`id`, `nombre`, `descripcion`, `estado`, `updated_at`, `created_at`, `orden`) VALUES
(1, 'Historial Médico', 'Escriba aquí sus problemas médicos actuales (con el año del diagnóstico) y cualquier hospitalización.', 1, '2023-05-27 03:35:59', NULL, 1),
(2, 'Historia Social', NULL, 1, '2023-05-27 03:32:01', NULL, 2),
(3, 'Revisión de los Sistema', NULL, 1, '2023-05-27 03:43:05', NULL, 3),
(4, 'Medicamentos', NULL, 1, '2023-05-27 04:13:17', NULL, 5),
(14, 'Historia Familiar', NULL, 1, '2023-05-27 03:45:03', '2023-05-19 02:20:05', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica_subsecciones`
--

CREATE TABLE `historia_clinica_subsecciones` (
  `id` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_clinica_subsecciones`
--

INSERT INTO `historia_clinica_subsecciones` (`id`, `id_seccion`, `nombre`, `descripcion`, `estado`, `updated_at`, `created_at`, `orden`) VALUES
(1, 1, 'Problemas Médicos Actuales', NULL, 1, '2023-05-01 21:29:41', '2023-05-01 21:29:41', 1),
(2, 1, 'Fracturas en el pasado', NULL, 1, '2023-05-06 02:10:50', '2023-05-01 21:32:03', 2),
(3, 1, 'Lesiones graves', NULL, 1, '2023-05-06 02:11:06', '2023-05-01 21:55:17', 3),
(4, 1, 'Pruebas', NULL, 1, '2023-05-06 02:11:39', '2023-05-06 02:11:39', 4),
(5, 1, 'Cirugías Significativas', NULL, 1, '2023-05-06 03:51:44', '2023-05-06 03:51:31', 5),
(6, 2, 'Historia Social', NULL, 1, '2023-05-27 05:59:16', '2023-05-07 01:48:39', 1),
(7, 3, 'CONSTITUCIONAL', NULL, 1, '2023-05-27 05:59:56', '2023-05-07 02:51:17', 1),
(8, 3, 'MUSCULOESQUELETAL', NULL, 1, '2023-05-27 06:00:11', '2023-05-07 02:52:41', 2),
(9, 3, 'ENDOCRINO', NULL, 1, '2023-05-27 06:00:39', '2023-05-07 02:53:03', 3),
(10, 3, 'PIEL', NULL, 1, '2023-05-27 06:01:15', '2023-05-07 02:53:35', 5),
(11, 3, 'OIDOS/NARIZ/GARGANTA', NULL, 1, '2023-05-27 06:01:24', '2023-05-07 02:53:47', 6),
(12, 14, 'Historia Familiar', NULL, 1, '2023-05-27 06:25:57', '2023-05-19 02:21:53', 1),
(15, 14, 'Historia Familiar', NULL, 1, '2023-05-27 06:26:07', '2023-05-27 03:46:48', 2),
(17, 4, 'Lista de Medicamentos que toma actualemente', NULL, 1, '2023-05-27 04:13:52', '2023-05-27 04:13:52', 1),
(18, 4, 'Alérgico Medicamentos', NULL, 1, '2023-05-27 04:16:59', '2023-05-27 04:16:59', 2),
(19, 3, 'OJOS', NULL, 1, '2023-05-27 06:00:59', '2023-05-27 05:32:47', 4),
(20, 3, 'RESPIRATORIO', NULL, 1, '2023-05-27 06:01:35', '2023-05-27 05:35:46', 7),
(21, 3, 'HEMATOLÓGICO', NULL, 1, '2023-05-27 06:01:50', '2023-05-27 05:42:07', 8),
(22, 3, 'NEUROLÓGICO', NULL, 1, '2023-05-27 06:03:25', '2023-05-27 05:42:22', 10),
(23, 3, 'PSIQUIÁTRICO', NULL, 1, '2023-05-27 06:03:50', '2023-05-27 05:43:09', 12),
(24, 3, 'EMBARAZOS', NULL, 1, '2023-05-27 06:04:16', '2023-05-27 05:43:22', 14),
(25, 3, 'CARDIOVASCULAR', NULL, 1, '2023-05-27 06:03:08', '2023-05-27 06:03:08', 9),
(26, 3, 'GASTROINTESTINAL', NULL, 1, '2023-05-27 06:03:40', '2023-05-27 06:03:40', 11),
(27, 3, 'URINARIO', NULL, 1, '2023-05-27 06:04:06', '2023-05-27 06:04:06', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_22_205624_estudios', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_medicas`
--

CREATE TABLE `notas_medicas` (
  `not_id` int(11) NOT NULL,
  `not_pac_id` int(11) NOT NULL,
  `not_fecha` date NOT NULL,
  `not_hora` time NOT NULL DEFAULT current_timestamp(),
  `not_descripcion` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas_medicas`
--

INSERT INTO `notas_medicas` (`not_id`, `not_pac_id`, `not_fecha`, `not_hora`, `not_descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-04-16', '21:46:25', 'Le paciente presenta Fiebre de mas de 38 grados', '2023-04-16 20:48:11', '2023-04-16 20:48:11'),
(2, 1, '2023-04-16', '21:46:25', 'El paciente presenta disminución de Fiebre 35 grados', '2023-04-16 20:48:41', '2023-04-16 20:48:41'),
(3, 1, '2023-04-16', '21:46:25', 'El paciente no presenta dolor en el área referida', '2023-04-16 20:49:22', '2023-04-16 20:49:22'),
(5, 1, '2023-05-18', '22:00:00', 'El paciente evoluciona de manera correcta', '2023-05-19 03:51:30', '2023-05-19 04:00:55'),
(6, 6, '2023-05-29', '21:45:31', 'Nota de evoluciòn', '2023-05-30 03:45:31', '2023-05-30 03:45:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `pac_id` int(11) NOT NULL,
  `pac_numero` int(11) NOT NULL,
  `pac_nombre` varchar(200) NOT NULL,
  `pac_paterno` varchar(200) NOT NULL,
  `pac_materno` varchar(200) DEFAULT NULL,
  `pac_nacimiento` date DEFAULT NULL,
  `pac_genero` char(1) NOT NULL,
  `pac_direccion` varchar(244) DEFAULT NULL,
  `pac_telefono` varchar(15) DEFAULT NULL,
  `pac_correo` varchar(244) DEFAULT NULL,
  `pac_use_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`pac_id`, `pac_numero`, `pac_nombre`, `pac_paterno`, `pac_materno`, `pac_nacimiento`, `pac_genero`, `pac_direccion`, `pac_telefono`, `pac_correo`, `pac_use_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Raúl', 'Alba', 'León', '1983-09-13', 'M', 'Bamba 33 Col. Benito Juárez, Nezahualcoyotl Mex', '5522987253', 'ralba2099@gmail.com', 1, '2023-04-08 20:53:39', '2023-04-08 20:53:39'),
(2, 2, 'Alejandro', 'Alba', 'Landeros', '2021-11-12', 'M', 'C. 17 #23 Col. Estado de México, Neza, México', '5522987253', 'ralba@correo.com', 1, '2023-04-08 21:08:21', '2023-04-08 21:08:21'),
(3, 3, 'Jorge', 'Sánchez', 'Vázquez', '1990-01-14', 'M', NULL, NULL, NULL, 1, '2023-04-08 21:10:18', '2023-04-08 21:10:18'),
(4, 4, 'Sandra', 'Castro', 'Salvatierra', '1979-01-13', 'F', NULL, NULL, NULL, 1, '2023-04-16 19:15:53', '2023-04-16 19:15:53'),
(5, 5, 'Alejandro', 'Camacho', NULL, '1983-09-13', 'M', NULL, NULL, NULL, 1, '2023-05-21 05:07:44', '2023-05-21 05:07:44'),
(6, 6, 'Nuevo paciente de pruebna', 'Paterno', 'Materno', '2023-05-17', 'F', NULL, NULL, NULL, 1, '2023-05-30 03:31:25', '2023-05-30 03:55:11'),
(7, 7, 'Pedro', 'dsa', 'klkl', '2023-05-29', 'M', NULL, NULL, NULL, 1, '2023-05-30 04:04:41', '2023-05-30 04:06:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('raulalba2099@gmail.com', '$2y$10$2gUkLzv8KBKQ01K5nLMV9uN1b8dZ2qsJunLYCqawNGCv0YV7SPMrG', '2023-04-17 00:26:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `rec_id` int(11) NOT NULL,
  `rec_cit_id` int(11) NOT NULL,
  `rec_medicamento` text NOT NULL,
  `rec_dosis` varchar(100) DEFAULT NULL,
  `rec_duracion` varchar(100) DEFAULT NULL,
  `rec_nota` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`rec_id`, `rec_cit_id`, `rec_medicamento`, `rec_dosis`, `rec_duracion`, `rec_nota`, `created_at`, `updated_at`) VALUES
(8, 113, 'Paracetamol 500 mg', '1/8', '7 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(9, 113, 'Azitromimcina 500 mg', '1/8', '7 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(10, 113, 'Diclofenaco 500 mg', '1/12', '5 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(11, 113, 'Paracetamol 500 mg', '1/8', '7 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(12, 113, 'Azitromimcina 500 mg', '1/8', '7 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(13, 113, 'Diclofenaco 500 mg', '1/8', '7 dìas', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(14, 113, 'Diclofenaco 500 mg', '1/7', '1 mes', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(15, 113, 'Salbutamo 100', '1/7', '1 mes', NULL, '2023-04-16 16:54:09', '2023-04-16 16:54:09'),
(18, 116, 'Medicamento', '1/8', '7 días', NULL, '2023-05-21 04:05:06', '2023-05-21 04:05:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Eduardo Mártinez León', 'raulalba2099@gmail.com', NULL, '$2y$10$Hb0CKEXjVkaY/yqE.0iujudp8GIzDWotLnvRnVzkF5ZrJuvLyhyCC', '41WsFsAkOjNNZsK33cPPGBtwnRUcgCJh1goy5G1kWYsRvBsBH14rhqraZUH9', '2023-02-18 11:46:57', '2023-02-18 11:46:57');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cit_id`),
  ADD KEY `cit_pac_id` (`cit_pac_id`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`con_id`),
  ADD KEY `con_cit_id` (`con_cit_id`);

--
-- Indices de la tabla `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`est_id`);

--
-- Indices de la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exa_pac_id` (`exa_pac_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  ADD PRIMARY KEY (`his_id`);

--
-- Indices de la tabla `historia_clinica_preguntas`
--
ALTER TABLE `historia_clinica_preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historia_clinica_respuestas`
--
ALTER TABLE `historia_clinica_respuestas`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `res_pre_id` (`res_pre_id`),
  ADD KEY `res_pac_id` (`res_pac_id`);

--
-- Indices de la tabla `historia_clinica_secciones`
--
ALTER TABLE `historia_clinica_secciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historia_clinica_subsecciones`
--
ALTER TABLE `historia_clinica_subsecciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas_medicas`
--
ALTER TABLE `notas_medicas`
  ADD PRIMARY KEY (`not_id`),
  ADD KEY `notas_medicas_fk_1` (`not_pac_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`pac_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `rec_cit_id` (`rec_cit_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `cit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudios`
--
ALTER TABLE `estudios`
  MODIFY `est_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  MODIFY `his_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historia_clinica_preguntas`
--
ALTER TABLE `historia_clinica_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `historia_clinica_respuestas`
--
ALTER TABLE `historia_clinica_respuestas`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `historia_clinica_secciones`
--
ALTER TABLE `historia_clinica_secciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `historia_clinica_subsecciones`
--
ALTER TABLE `historia_clinica_subsecciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notas_medicas`
--
ALTER TABLE `notas_medicas`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `pac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`cit_pac_id`) REFERENCES `pacientes` (`pac_id`);

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`con_cit_id`) REFERENCES `citas` (`cit_id`);

--
-- Filtros para la tabla `examen_fisico`
--
ALTER TABLE `examen_fisico`
  ADD CONSTRAINT `examen_fisico_ibfk_1` FOREIGN KEY (`exa_pac_id`) REFERENCES `pacientes` (`pac_id`);

--
-- Filtros para la tabla `historia_clinica_respuestas`
--
ALTER TABLE `historia_clinica_respuestas`
  ADD CONSTRAINT `historia_clinica_respuestas_ibfk_1` FOREIGN KEY (`res_pre_id`) REFERENCES `historia_clinica_preguntas` (`id`),
  ADD CONSTRAINT `historia_clinica_respuestas_ibfk_2` FOREIGN KEY (`res_pac_id`) REFERENCES `pacientes` (`pac_id`);

--
-- Filtros para la tabla `historia_clinica_subsecciones`
--
ALTER TABLE `historia_clinica_subsecciones`
  ADD CONSTRAINT `id_seccion` FOREIGN KEY (`id_seccion`) REFERENCES `historia_clinica_secciones` (`id`);

--
-- Filtros para la tabla `notas_medicas`
--
ALTER TABLE `notas_medicas`
  ADD CONSTRAINT `notas_medicas_fk_1` FOREIGN KEY (`not_pac_id`) REFERENCES `pacientes` (`pac_id`);

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`rec_cit_id`) REFERENCES `citas` (`cit_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
