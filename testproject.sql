-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 28 2023 г., 18:16
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testproject`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` float NOT NULL,
  `product_article` varchar(100) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `date_create` date NOT NULL,
  `product_show` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `product_price`, `product_article`, `product_quantity`, `date_create`, `product_show`) VALUES
(1, 282, 'Продукт-1', 5863, 'PA-1', 52, '2023-04-27', 1),
(2, 260, 'Продукт-2', 10400, 'PA-2', 9, '2023-06-27', 1),
(3, 401, 'Продукт-3', 899.5, 'PA-3', 8, '2023-01-14', 1),
(4, 200, 'Продукт-4', 15700, 'PA-4', 73, '2023-04-10', 1),
(5, 22, 'Продукт-5', 4444, 'PA-5', 590, '2022-07-11', 1),
(6, 303, 'Продукт-6', 6199.25, 'PA-6', 5, '2023-03-20', 1),
(7, 28, 'Продукт-7', 7905, 'PA-7', 15, '2022-07-01', 1),
(8, 59, 'Продукт-8', 8222, 'PA-8', 55, '2023-02-22', 1),
(9, 2, 'Продукт-9', 5403.35, 'PA-9', 40, '2023-04-27', 1),
(10, 166, 'Продукт-10', 5600, 'PA-10', 302, '2023-03-20', 1),
(11, 13, 'Продукт-11', 6472, 'PA-11', 11, '2023-09-14', 1),
(12, 94, 'Продукт-12', 1100, 'PA-12', 22, '2023-03-18', 1),
(13, 777, 'Продукт-13', 7777, 'PA-13', 13, '2022-09-13', 1),
(14, 268, 'Продукт-14', 75444, 'PA-14', 100, '2023-01-01', 1),
(15, 333, 'Продукт-15', 9980, 'PA-15', 54, '2023-07-14', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD UNIQUE KEY `product_article` (`product_article`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
