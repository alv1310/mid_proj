-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-05-11 17:52:20
-- 伺服器版本： 10.4.18-MariaDB
-- PHP 版本： 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `article`
--
CREATE DATABASE IF NOT EXISTS `article` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `article`;

-- --------------------------------------------------------

--
-- 資料表結構 `acategorylist`
--

CREATE TABLE `acategorylist` (
  `aCatId` int(11) NOT NULL COMMENT '流水號',
  `aCatName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '類別名稱',
  `aCatParentId` int(11) DEFAULT 0 COMMENT '上層編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='類別資料表';

--
-- 傾印資料表的資料 `acategorylist`
--

INSERT INTO `acategorylist` (`aCatId`, `aCatName`, `aCatParentId`, `created_at`, `updated_at`) VALUES
(2, '露營新手指南', 0, '2021-05-03 15:27:18', '2021-05-11 10:45:31'),
(3, '親子同遊露營', 0, '2021-05-03 16:25:32', '2021-05-05 14:51:46'),
(4, '深度野營探索', 0, '2021-05-04 09:32:41', '2021-05-05 14:52:43'),
(5, '奢華露營體驗', 0, '2021-05-05 12:09:51', '2021-05-05 14:52:57');

-- --------------------------------------------------------

--
-- 資料表結構 `acommentlist`
--

CREATE TABLE `acommentlist` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內容',
  `rating` tinyint(1) NOT NULL COMMENT '評分',
  `parentId` int(11) NOT NULL DEFAULT 0 COMMENT '上(父)層編號',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='評論';

--
-- 傾印資料表的資料 `acommentlist`
--

INSERT INTO `acommentlist` (`id`, `name`, `content`, `rating`, `parentId`, `itemId`, `created_at`, `updated_at`) VALUES
(1, '', 'good', 5, 0, 2, '2021-04-23 10:44:06', '2021-04-23 10:44:06'),
(2, 'Amy', 'good', 5, 0, 2, '2021-04-23 10:44:16', '2021-04-23 10:44:16'),
(3, '管理員', 'thanks ', 0, 1, 2, '2021-04-23 10:56:53', '2021-04-23 10:56:53'),
(4, '管理員', 'thank you!', 0, 2, 2, '2021-04-23 10:57:02', '2021-04-23 10:57:02');

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者帳號',
  `pwd` char(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者密碼',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '管理者姓名',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理者帳號';

--
-- 傾印資料表的資料 `admin`
--

INSERT INTO `admin` (`id`, `username`, `pwd`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '後台管理員', '2021-04-23 09:45:43', '2021-05-11 23:21:00');

-- --------------------------------------------------------

--
-- 資料表結構 `articlelist`
--

CREATE TABLE `articlelist` (
  `aId` int(11) NOT NULL COMMENT '流水號',
  `aTitle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名稱',
  `aImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品照片路徑',
  `author` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者',
  `aContent` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文',
  `aCategoryId` int(11) NOT NULL COMMENT '商品種類編號',
  `aCommentId` int(11) NOT NULL COMMENT '評論編號',
  `aTagId` int(11) NOT NULL COMMENT '標籤編號',
  `aDate` date NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章列表';

--
-- 傾印資料表的資料 `articlelist`
--

INSERT INTO `articlelist` (`aId`, `aTitle`, `aImg`, `author`, `aContent`, `aCategoryId`, `aCommentId`, `aTagId`, `aDate`, `created_at`, `updated_at`) VALUES
(3, '出去玩!', 'item_20210511172908.jpg', 'Terri', '                                                                                                            現在預定宜蘭東風綠活夢幻露營，免裝備露營輕鬆入住露營帳，新手露營推薦！入住純白系神殿帳篷、享用宜蘭味料理餐桌、體驗療癒系手作，及用心維護生態平衡的天然營地與舒適衛浴設施。不須自己搭帳篷，還有貼心小管家服務，只要帶上個人行李，就能輕鬆開啟你的夢幻露營生活！      \r\n\r\n現在預定宜蘭東風綠活夢幻露營，免裝備露營輕鬆入住露營帳，新手露營推薦！                                                                                                                   ', 3, 0, 0, '2021-05-07', '2021-05-04 12:17:53', '2021-05-11 23:29:08'),
(4, '夏季旅遊', 'item_20210511154757.jpg', 'Jude ', '                                        宜蘭夢幻露營專為想要旅行出走、投入自然森活的你設計，這是以感受生活、職感體驗為主的免裝備露營。宜蘭夢幻露營提供純白系神殿帳篷、宜蘭味料理餐桌、療癒系手作體驗，及用心維護生態平衡的天然營地與舒適衛浴設施。不須自己搭帳篷，還有貼心小管家服務，只要帶上個人行李，就能輕鬆開啟你的夢幻露營生活。                                ', 4, 0, 0, '2021-05-07', '2021-05-04 12:18:38', '2021-05-11 21:48:35'),
(6, '風格露營', 'item_20210511155138.jpg', 'Connor', ' 那一村提供現在最流行的glamping 帳篷住宿，野奢酒店的概念帶給旅客全新的豪華露營體驗。\r\n露營園區位於宜蘭縣礁溪鄉與員山鄉交界處，二鄉以大礁溪為鄰，海拔約 200 公尺，三面環山。\r\n當地可經常見到台灣獼猴、台灣藍鵲、白鷺絲、夜鷹與啄木鳥等野生動物，那一村提供一泊三食早餐、下午茶、晚餐服務，讓您在這悠然山林中盡情享受美食。下午茶提供三層式精緻下午茶和現做熱餐點，每帳提供一套。\r\n                                                ', 5, 0, 0, '2021-05-07', '2021-05-05 09:51:37', '2021-05-11 22:49:49'),
(7, '高海拔營地', 'item_20210511155045.jpg', 'Alex', '                    現在預訂宜蘭兩天一夜旅行，搭乘遊覽車前往宜蘭，瀏覽宜蘭猴洞坑瀑布、兔子迷宮咖啡餐廳、渭水之丘等景點。入住豪華 Nayi Villa 那一村體驗現正流行的 Glamping 豪華露營住宿，每個帳篷具備獨立衛浴，於 KKday 預訂行程還可享一泊三食優惠，品嚐下午茶、晚餐與隔天早餐。                ', 4, 0, 0, '2021-05-07', '2021-05-05 09:51:58', '2021-05-11 21:50:45'),
(8, '愛露營上山下海', 'item_20210505174732.jpg', 'Anabel Gates ', '                                        現在預定苗栗山美學露營 2 天 1 夜，免裝備露營輕鬆入住露營帳，新手露營推薦！到戶外親近大自然零負擔，飯店級寢具、電源插座，一泊二食附 BBQ 晚餐及早餐。                                ', 2, 0, 0, '2021-05-07', '2021-05-05 10:50:34', '2021-05-11 16:22:48'),
(10, '放暑假', 'item_20210505141317.jpg', 'Benny Santos', '和親朋好友一起療癒身心，享受在浪漫花園裡的慢活生活、以及共煮共食的樂趣。可依偏好選擇純租營位自搭帳，或是免搭帳懶人輕鬆露。非常適合新手的懶人露營空間，環境清新優美。雖然不比飯店乾淨整潔，但畢竟是露營，貼近大自然的體驗也是重點之一。                ', 5, 0, 0, '2021-05-07', '2021-05-05 12:13:17', '2021-05-10 21:21:23'),
(11, '說走就走', 'item_20210511154710.jpg', 'anne', '                                        露營車內提供冷暖氣與獨立衛浴，室外擁有私人露台，還能在園區內戶外 SPA 大眾湯度過悠閒的午後，立即在 KKday 訂購，享受最愜意的露營體驗吧！\r\n\r\n一泊一食，輕鬆享受露營車樂趣，省去所有繁雜程序\r\n獨立衛浴與私人戶外露臺，與家人朋友一起共享歡樂時光\r\n入住豪華露營車還能使用戶外SPA大眾湯，感受美人湯魅力                                ', 2, 0, 0, '2021-05-07', '2021-05-05 13:15:19', '2021-05-11 21:47:10'),
(12, '合掌村 & 小木屋', 'item_20210511171158.jpg', 'Ready', '                        和親友們一起放慢腳步遠離城市的喧囂，在園區內寬廣的草原及豐富的遊樂設施讓孩子們盡情地奔跑、玩樂，大人們可以免費體驗高爾夫球，一家大小一起在大自然的包圍下，享受悠閒的度假時光。                                      ', 4, 0, 0, '2021-05-07', '2021-05-05 13:15:38', '2021-05-11 23:11:58'),
(13, '輕鬆入住 ．一泊三食', 'item_20210511154110.jpg', 'LISA', '                                                                                現在預定宜蘭東風綠活夢幻露營，免裝備露營輕鬆入住露營帳，新手露營推薦！入住純白系神殿帳篷、享用宜蘭味料理餐桌、體驗療癒系手作，及用心維護生態平衡的天然營地與舒適衛浴設施。\r\n\r\n不須自己搭帳篷，還有貼心小管家服務，只要帶上個人行李，就能輕鬆開啟你的夢幻露營生活！                                                                                ', 3, 0, 0, '2021-05-07', '2021-05-05 13:16:18', '2021-05-11 21:41:10'),
(14, '花蓮豪華露營地踏浪星辰', 'item_20210505151643.jpg', 'Rach', '立即預訂花蓮豪華露營地踏浪星辰，與七星潭、星空零距離接觸，忘記心中的煩惱，喜歡旅行和大自然的朋友們，等著一同探險，感受露營的美妙，立即從 KKday 預訂，與家人朋友共享美好時光，一起玩樂與烤肉，捕捉生命中的美好回憶。', 2, 0, 0, '2021-05-07', '2021-05-05 13:16:43', '2021-05-05 16:11:09'),
(15, '免裝備風格露營', 'item_20210511153933.jpg', 'Tom', '                                            現在訂購苗栗黃金梯田風格露營兩天一夜，免裝備入住景觀大師操刀的風格景致露營區。黃金梯田位於苗栗杭菊花海的中心點，俗稱十一月雪，春有綠芽新發，夏有稻浪波湧，秋有杭菊花海，冬享茶香滿溢，景緻隨四季遞嬗而變化，是網美拍照、家庭享樂的絕佳地點。                                        ', 2, 0, 0, '2021-05-07', '2021-05-05 13:17:00', '2021-05-11 21:39:33'),
(21, '野餐', 'item_20210511152649.jpg', 'Annee', '                                        風和日麗的午後，坐在一片綠草如茵的大草皮上，拿出你前陣子特別挑選的繽紛野餐墊，再從藤編的野餐籃裡，將一大早起床準備的三明治、壽司盒、切片水果、冷泡茶撲滿野餐墊，招呼著今天召集的好友們，一邊大啖美食、一邊在草地上玩遊戲，專屬假日午後的野餐趴踢，正式開始！                                ', 2, 0, 0, '2021-05-11', '2021-05-11 16:32:08', '2021-05-11 22:50:37'),
(22, '輕鬆入住 ．一泊三食', 'item_20210511164544.jpg', 'anybody', ' 一秒變身網美 | 獨家！只有這一檔 ＼PAZZO 風格帳／\r\n\r\n 營主有點海派 | 請你吃澎湃烤肉晚餐. 免費空拍小人照\r\n\r\n 我們也很佛心 | 入住送你風格小禮. PAZZO獨家折扣碼\r\n\r\n 很多放電活動 | 獨家！BenQ 露營星空電影院天天放映\r\n\r\n走！一起去露營\r\n\r\n', 5, 0, 0, '2021-05-11', '2021-05-11 22:45:44', '2021-05-11 22:45:44'),
(24, '懶人露營好簡單', 'item_20210511171305.jpg', 'KK', '                    踏浪星辰露營 Camp 位於花蓮縣大漢村，距離七星潭僅 100 公尺，住宿可通花園，並設有露台和觀光旅遊櫃台。此帳篷營地可提供免費私人停車位，並設有公共休息區，戶外區有細白沙坑、樹屋溜滑梯、盪鞦韆等遊樂設施，營主還有養小狗、小貓等動物，吸引小朋友的注意，且營區在七星潭旁，相當適合帶小朋友看海踏浪、撿小石頭，度過愜意時光                ', 2, 0, 0, '2021-05-11', '2021-05-11 23:08:13', '2021-05-11 23:13:05'),
(25, '花蓮露營｜踏浪星辰 Camp', 'item_20210511171159.jpg', 'KEN', '                                        立即預訂花蓮豪華露營地踏浪星辰，與七星潭、星空零距離接觸，忘記心中的煩惱，喜歡旅行和大自然的朋友們，等著一同探險，感受露營的美妙，立即預訂，與家人朋友共享美好時光，一起玩樂與烤肉，捕捉生命中的美好回憶。      ', 5, 0, 0, '2021-05-11', '2021-05-11 23:09:26', '2021-05-11 23:11:59');

-- --------------------------------------------------------

--
-- 資料表結構 `ataglist`
--

CREATE TABLE `ataglist` (
  `tagId` int(11) NOT NULL COMMENT '標籤編號',
  `tagName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '標籤名稱',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `ataglist`
--

INSERT INTO `ataglist` (`tagId`, `tagName`, `created_at`, `updated_at`) VALUES
(1, '#星期六', '2021-05-10 21:42:06', '2021-05-11 10:59:33'),
(2, '#夜景', '2021-05-10 21:42:06', '2021-05-10 21:45:49'),
(3, '#免裝備', '2021-05-10 21:43:28', '2021-05-10 21:43:28'),
(4, '#高海拔', '2021-05-10 21:43:28', '2021-05-10 21:45:00'),
(5, '#釣魚', '2021-05-10 21:44:23', '2021-05-10 21:44:23'),
(6, '#大草皮', '2021-05-10 21:44:23', '2021-05-10 21:44:23'),
(7, '#櫻花', '2021-05-10 21:45:21', '2021-05-10 21:45:21'),
(8, '#雲海', '2021-05-10 21:45:21', '2021-05-10 21:45:21'),
(9, '#近溪流', '2021-05-10 21:46:31', '2021-05-10 21:46:31'),
(10, '#兒童親子', '2021-05-10 21:46:31', '2021-05-10 21:46:31');

-- --------------------------------------------------------

--
-- 資料表結構 `atagmap`
--

CREATE TABLE `atagmap` (
  `tmId` int(11) NOT NULL COMMENT '標籤索引編號',
  `tagId` int(11) NOT NULL COMMENT '標籤編號',
  `aId` int(11) NOT NULL COMMENT '文章編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `atagmap`
--

INSERT INTO `atagmap` (`tmId`, `tagId`, `aId`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2021-05-10 22:19:45', '2021-05-10 22:19:45'),
(2, 3, 2, '2021-05-10 22:19:45', '2021-05-10 22:19:45'),
(3, 4, 11, '2021-05-10 22:20:17', '2021-05-10 22:20:17'),
(4, 7, 11, '2021-05-10 22:20:17', '2021-05-10 22:20:17'),
(5, 2, 15, '2021-05-10 22:20:56', '2021-05-10 22:20:56'),
(6, 5, 15, '2021-05-10 22:20:56', '2021-05-10 22:20:56'),
(7, 6, 14, '2021-05-10 22:21:15', '2021-05-10 22:21:15'),
(8, 7, 13, '2021-05-10 22:21:15', '2021-05-10 22:21:15'),
(9, 8, 9, '2021-05-10 22:21:32', '2021-05-10 22:21:32'),
(10, 9, 10, '2021-05-10 22:21:32', '2021-05-10 22:21:32'),
(11, 10, 4, '2021-05-10 22:22:42', '2021-05-10 22:22:42'),
(12, 10, 12, '2021-05-10 22:22:42', '2021-05-10 22:22:42'),
(13, 6, 7, '2021-05-10 22:23:10', '2021-05-10 22:23:10'),
(14, 9, 6, '2021-05-10 22:23:10', '2021-05-10 22:23:10'),
(15, 1, 3, '2021-05-10 22:25:17', '2021-05-10 22:25:17'),
(16, 3, 8, '2021-05-10 22:25:17', '2021-05-10 22:25:17'),
(17, 10, 3, '2021-05-10 22:31:23', '2021-05-10 22:31:23'),
(18, 7, 3, '2021-05-10 22:31:23', '2021-05-10 22:31:23'),
(19, 6, 4, '2021-05-10 22:31:56', '2021-05-10 22:31:56'),
(20, 3, 6, '2021-05-10 22:31:56', '2021-05-10 22:31:56'),
(21, 5, 7, '2021-05-10 22:32:23', '2021-05-10 22:32:23'),
(22, 7, 8, '2021-05-10 22:32:23', '2021-05-10 22:32:23'),
(23, 1, 9, '2021-05-10 22:32:52', '2021-05-10 22:32:52'),
(24, 2, 9, '2021-05-10 22:32:52', '2021-05-10 22:32:52'),
(25, 2, 11, '2021-05-10 22:33:27', '2021-05-10 22:33:27'),
(26, 5, 12, '2021-05-10 22:33:27', '2021-05-10 22:33:27'),
(27, 10, 13, '2021-05-10 22:34:11', '2021-05-10 22:34:11'),
(28, 9, 14, '2021-05-10 22:34:11', '2021-05-10 22:34:11'),
(29, 2, 22, '2021-05-11 23:42:22', '2021-05-11 23:42:22'),
(30, 4, 22, '2021-05-11 23:42:22', '2021-05-11 23:42:22'),
(31, 8, 22, '2021-05-11 23:42:51', '2021-05-11 23:42:51'),
(32, 4, 21, '2021-05-11 23:42:51', '2021-05-11 23:42:51'),
(33, 9, 24, '2021-05-11 23:43:22', '2021-05-11 23:43:22'),
(34, 10, 24, '2021-05-11 23:43:22', '2021-05-11 23:43:22'),
(35, 7, 25, '2021-05-11 23:43:51', '2021-05-11 23:43:51'),
(36, 4, 25, '2021-05-11 23:43:51', '2021-05-11 23:43:51');

-- --------------------------------------------------------

--
-- 資料表結構 `item_lists`
--

CREATE TABLE `item_lists` (
  `itemListId` int(11) NOT NULL COMMENT '流水號',
  `orderId` int(11) NOT NULL COMMENT '訂單編號',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `checkPrice` int(11) NOT NULL COMMENT '結帳時單價',
  `checkQty` tinyint(3) NOT NULL COMMENT '結帳時數量',
  `checkSubtotal` int(11) NOT NULL COMMENT '結帳時小計',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='訂單中的商品列表';

--
-- 傾印資料表的資料 `item_lists`
--

INSERT INTO `item_lists` (`itemListId`, `orderId`, `itemId`, `checkPrice`, `checkQty`, `checkSubtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 80, 20, 1600, '2021-04-23 10:42:09', '2021-04-23 10:42:09'),
(2, 1, 2, 60, 20, 1200, '2021-04-23 10:42:09', '2021-04-23 10:42:09'),
(3, 2, 6, 60, 1, 60, '2021-05-05 14:29:39', '2021-05-05 14:29:39'),
(4, 2, 8, 20, 2, 40, '2021-05-05 14:29:39', '2021-05-05 14:29:39'),
(5, 3, 3, 80, 6, 480, '2021-05-05 14:44:44', '2021-05-05 14:44:44'),
(6, 3, 5, 80, 4, 320, '2021-05-05 14:44:44', '2021-05-05 14:44:44');

-- --------------------------------------------------------

--
-- 資料表結構 `item_tracking`
--

CREATE TABLE `item_tracking` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者帳號',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '訊息',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品追縱';

--
-- 傾印資料表的資料 `item_tracking`
--

INSERT INTO `item_tracking` (`id`, `username`, `itemId`, `msg`, `created_at`, `updated_at`) VALUES
(1, 'test', 2, NULL, '2021-04-23 10:43:57', '2021-04-23 10:43:57');

-- --------------------------------------------------------

--
-- 資料表結構 `multiple_images`
--

CREATE TABLE `multiple_images` (
  `multipleImageId` int(11) NOT NULL COMMENT '流水號',
  `multipleImageImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片名稱',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品圖片';

--
-- 傾印資料表的資料 `multiple_images`
--

INSERT INTO `multiple_images` (`multipleImageId`, `multipleImageImg`, `itemId`, `created_at`, `updated_at`) VALUES
(1, 'multiple_images_20210423044251_0.jpg', 1, '2021-04-23 10:42:51', '2021-04-23 10:42:51'),
(2, 'multiple_images_20210423044251_1.jpg', 1, '2021-04-23 10:42:51', '2021-04-23 10:42:51'),
(3, 'multiple_images_20210423044251_2.jpg', 1, '2021-04-23 10:42:51', '2021-04-23 10:42:51'),
(4, 'multiple_images_20210423044251_3.jpg', 1, '2021-04-23 10:42:51', '2021-04-23 10:42:51');

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者帳號',
  `paymentTypeId` int(11) NOT NULL COMMENT '付款方式',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='結帳資料表';

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`orderId`, `username`, `paymentTypeId`, `created_at`, `updated_at`) VALUES
(1, 'test', 3, '2021-04-23 10:42:09', '2021-04-23 10:42:09'),
(2, 'test', 0, '2021-05-05 14:29:39', '2021-05-05 14:29:39'),
(3, 'test', 0, '2021-05-05 14:44:44', '2021-05-05 14:44:44');

-- --------------------------------------------------------

--
-- 資料表結構 `payment_types`
--

CREATE TABLE `payment_types` (
  `paymentTypeId` int(11) NOT NULL COMMENT '流水號',
  `paymentTypeName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '付款方式名稱',
  `paymentTypeImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '付款方式圖片名稱',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='付款方式';

--
-- 傾印資料表的資料 `payment_types`
--

INSERT INTO `payment_types` (`paymentTypeId`, `paymentTypeName`, `paymentTypeImg`, `created_at`, `updated_at`) VALUES
(1, 'LINE pay', 'payment_type_20210423041725.png', '2021-04-23 10:17:25', '2021-04-23 10:17:25'),
(2, 'Samsung Pay', 'payment_type_20210423041742.jpg', '2021-04-23 10:17:42', '2021-04-23 10:17:42'),
(3, 'Apple Pay', 'payment_type_20210423041819.png', '2021-04-23 10:17:56', '2021-04-23 10:18:19');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者名稱',
  `pwd` char(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者密碼',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '性別',
  `phoneNumber` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機號碼',
  `birthday` date NOT NULL COMMENT '出生年月日',
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `isActivated` tinyint(1) NOT NULL DEFAULT 1 COMMENT '開通狀況',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者資料表';

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `name`, `gender`, `phoneNumber`, `birthday`, `address`, `isActivated`, `created_at`, `updated_at`) VALUES
(1, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Amy', '女', '0912312312', '0000-00-00', '000', 1, '2021-04-23 10:41:51', '2021-04-23 10:41:51');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `acategorylist`
--
ALTER TABLE `acategorylist`
  ADD PRIMARY KEY (`aCatId`);

--
-- 資料表索引 `acommentlist`
--
ALTER TABLE `acommentlist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `articlelist`
--
ALTER TABLE `articlelist`
  ADD PRIMARY KEY (`aId`);

--
-- 資料表索引 `ataglist`
--
ALTER TABLE `ataglist`
  ADD PRIMARY KEY (`tagId`);

--
-- 資料表索引 `atagmap`
--
ALTER TABLE `atagmap`
  ADD PRIMARY KEY (`tmId`);

--
-- 資料表索引 `item_lists`
--
ALTER TABLE `item_lists`
  ADD PRIMARY KEY (`itemListId`);

--
-- 資料表索引 `item_tracking`
--
ALTER TABLE `item_tracking`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `multiple_images`
--
ALTER TABLE `multiple_images`
  ADD PRIMARY KEY (`multipleImageId`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- 資料表索引 `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`paymentTypeId`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `acategorylist`
--
ALTER TABLE `acategorylist`
  MODIFY `aCatId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `acommentlist`
--
ALTER TABLE `acommentlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `articlelist`
--
ALTER TABLE `articlelist`
  MODIFY `aId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=26;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `ataglist`
--
ALTER TABLE `ataglist`
  MODIFY `tagId` int(11) NOT NULL AUTO_INCREMENT COMMENT '標籤編號', AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `atagmap`
--
ALTER TABLE `atagmap`
  MODIFY `tmId` int(11) NOT NULL AUTO_INCREMENT COMMENT '標籤索引編號', AUTO_INCREMENT=37;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `item_lists`
--
ALTER TABLE `item_lists`
  MODIFY `itemListId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `item_tracking`
--
ALTER TABLE `item_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `multiple_images`
--
ALTER TABLE `multiple_images`
  MODIFY `multipleImageId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `paymentTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
