-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 09 2018 г., 13:34
-- Версия сервера: 5.7.13
-- Версия PHP: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php20hw14`
--

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `user_id`, `assigned_user_id`, `description`, `is_done`, `date_added`) VALUES
(5, 1, 1, 'Тестовый запрос 1', 1, '2018-03-09 18:42:51'),
(7, 1, 2, 'Тестовый запрос', 0, '2018-03-09 18:43:00'),
(8, 2, 2, 'task1', 1, '2018-03-09 21:30:02'),
(9, 2, 1, 'task2', 0, '2018-03-09 21:30:31'),
(10, 2, 2, 'task3', 0, '2018-03-09 21:30:39'),
(11, 2, 1, 'task4', 1, '2018-03-09 21:30:47');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`) VALUES
(1, 'user', 'c83a73ed415ed9f1a6a23e2a1ab33b378cc6b6d9a12ed618ff07321cb6c6116e'),
(2, 'user1', 'c207ab5a4484887da1a614c241670069c28610db67adead0405266ffcc0cf884');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_user_id` (`assigned_user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`assigned_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
