-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 26, 2024 at 03:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webcongnghe`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int NOT NULL,
  `tag` varchar(255) NOT NULL,
  `patterns` varchar(255) NOT NULL,
  `responses` varchar(255) NOT NULL,
  `context` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `tag`, `patterns`, `responses`, `context`) VALUES
(1, 'greeting', 'Hi there\", \"How are you\", \"Is anyone there?\", \"Hey\", \"Hola\", \"Hello\", \"Good day', 'Hello, thanks for asking\", \"Good to see you again\", \"Hi there, how can I help?', ''),
(2, 'goodbye', 'Bye\", \"See you later\", \"Goodbye\", \"Nice chatting to you, bye\", \"Till next time', 'See you!\", \"Have a nice day\", \"Bye! Come back again soon.', ''),
(3, 'thanks', 'Thanks\", \"Thank you\", \"That\'s helpful\", \"Awesome, thanks\", \"Thanks for helping me', 'Happy to help!\", \"Any time!\", \"My pleasure', ''),
(4, 'noanswer', '[]', 'Sorry, can\'t understand you\", \"Please give me more info\", \"Not sure I understand', ''),
(5, 'options', 'How you could help me?\", \"What you can do?\", \"What help you provide?\", \"How you can be helpful?\", \"What support is offered', 'I can guide you through Adverse drug reaction list, Blood pressure tracking, Hospitals and Pharmacies\", \"Offering support for Adverse drug reaction, Blood pressure, Hospitals and Pharmacies', ''),
(6, 'adverse_drug', 'How to check Adverse drug reaction?\", \"Open adverse drugs module\", \"Give me a list of drugs causing adverse behavior\", \"List all drugs suitable for patient with adverse reaction\", \"Which drugs dont have adverse reaction?', 'Navigating to Adverse drug reaction module', ''),
(7, 'blood_pressure', 'Open blood pressure module\", \"Task related to blood pressure\", \"Blood pressure data entry\", \"I want to log blood pressure results\", \"Blood pressure data management', 'Navigating to Blood Pressure module', ''),
(8, 'blood_pressure_search', 'I want to search for blood pressure result history\", \"Blood pressure for patient\", \"Load patient blood pressure result\", \"Show blood pressure results for patient\", \"Find blood pressure results by ID', 'Please provide Patient ID\", \"Patient ID?', 'search_blood_pressure_by_patient_id'),
(9, 'search_blood_pressure_by_patient_id', '[]', 'Loading Blood pressure result for Patient', ''),
(10, 'pharmacy_search', 'Find me a pharmacy\", \"Find pharmacy\", \"List of pharmacies nearby\", \"Locate pharmacy\", \"Search pharmacy', 'Please provide pharmacy name', 'search_pharmacy_by_name'),
(11, 'search_pharmacy_by_name', '[]', 'Loading pharmacy details', ''),
(12, 'hospital_search', 'Lookup for hospital\", \"Searching for hospital to transfer patient\", \"I want to search hospital data\", \"Hospital lookup for patient\", \"Looking up hospital details', 'Please provide hospital name or location', 'search_hospital_by_params'),
(13, 'search_hospital_by_params', '[]', 'Please provide hospital type', 'search_hospital_by_type'),
(14, 'search_hospital_by_type', '[]', 'Loading hospital details', ''),
(15, 'action_danhmucsanpham', 'Các thương hiệu sản phẩm nào?', 'Có 4 thương hiệu trong cửa hàng đó là Acer, Samsung, Oppo, Apple.', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_binhluan`
--

CREATE TABLE `tbl_binhluan` (
  `binhluan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `tenbinhluan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `binhluan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_binhluan`
--

INSERT INTO `tbl_binhluan` (`binhluan_id`, `user_id`, `tenbinhluan`, `binhluan`, `product_id`) VALUES
(1, 1, 'Đạt', 'Sản phẩm okie', 1),
(3, 1, 'Đạt', 'Máy ảnh chất lượng mọi người nên mua', 4),
(4, 3, 'Linh', 'Máy ảnh okie', 4),
(5, 1, 'Đạt', 'Đẹp quá', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `id` int NOT NULL,
  `title_blog` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_blog` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_cate_post` int NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `title_blog`, `desc_blog`, `content`, `id_cate_post`, `image`, `status`) VALUES
(2, 'HLV Nhật Bản: \'Chúng tôi không thể áp đặt Việt Nam như kế hoạch\'', '<p>HLV Hajime Moriyasu bất ngờ khi Nhật Bản bị dẫn trước v&agrave; thừa nhận rất kh&oacute; khăn để đ&aacute;nh bại Việt Nam 4-2 trong ng&agrave;y ra qu&acirc;n Asian Cup 2023.</p>', '<p>\"T&ocirc;i biết người h&acirc;m mộ Nhật Bản muốn ch&uacute;ng t&ocirc;i gi&agrave;nh chiến thắng &aacute;p đảo. Nhưng trận đầu ti&ecirc;n ở c&aacute;c giải đấu lớn lu&ocirc;n kh&oacute; khăn. Thực tế trước Việt Nam trận n&agrave;y dạy cho ch&uacute;ng t&ocirc;i một b&agrave;i học, rằng chẳng c&oacute; trận n&agrave;o dễ d&agrave;ng ở Asian Cup. Thật may, c&aacute;c cầu thủ của t&ocirc;i đ&atilde; b&igrave;nh tĩnh, th&iacute;ch ứng kịp thời với t&igrave;nh thế để gi&agrave;nh chiến thắng v&agrave; tự tin hướng đến c&aacute;c trận tiếp theo\", Moriyasu n&oacute;i tại họp b&aacute;o sau trận đấu tr&ecirc;n s&acirc;n Al Thumama.</p>', 5, '99eea9fbb3.jpg', 0),
(4, 'Giá vàng tuần này có thể tăng cao vì căng thẳng chính trị', '<p><span>Diễn biến tại Trung Đ&ocirc;ng được dự b&aacute;o tiếp tục k&eacute;o gi&aacute; v&agrave;ng l&ecirc;n cao, lấn &aacute;t t&aacute;c động của USD v&agrave; l&atilde;i suất.</span></p>', '<p><a href=\"https://vnexpress.net/chu-de/gia-vang-hom-nay-1403\" rel=\"dofollow\" data-itm-source=\"#vn_source=Detail-KinhDoanh_QuocTe-4700574&amp;vn_campaign=Box-InternalLink&amp;vn_medium=Link-GiaVang&amp;vn_term=Desktop&amp;vn_thumb=0\" data-itm-added=\"1\">Gi&aacute; v&agrave;ng</a><span>&nbsp;thế giới giao ngay h&ocirc;m 12/1 l&ecirc;n cao nhất một tuần tại 2.061 USD. Nguy&ecirc;n nh&acirc;n l&agrave; căng thẳng tại Trung Đ&ocirc;ng k&eacute;o nhu cầu tr&uacute; ẩn l&ecirc;n cao, v&agrave; chỉ số gi&aacute; sản xuất (PPI) của Mỹ giảm l&agrave;m tăng khả năng Cục dự trữ Li&ecirc;n bang Mỹ - Fed hạ l&atilde;i suất sớm hơn dự kiến.</span></p>', 4, '7bd1c9e194.jpg', 0),
(5, 'Tại sao lên Mặt Trăng ngày nay \'khó\' hơn 50 năm trước?', '<p><span>Th&aacute;ch thức trong việc chế tạo t&agrave;u, qu&aacute; tr&igrave;nh hạ c&aacute;nh v&agrave; sự thiếu kinh nghiệm của c&aacute;c c&ocirc;ng ty tư nh&acirc;n khiến nhiều t&agrave;u đổ bộ Mặt Trăng gần đ&acirc;y thất bại.</span></p>', '<p class=\"Normal\">Bản th&acirc;n Mặt Trăng cũng đặt ra nhiều th&aacute;ch thức cho c&aacute;c t&agrave;u vũ trụ. Thi&ecirc;n thể n&agrave;y c&oacute; lực hấp dẫn - mạnh bằng 1/6 Tr&aacute;i Đất - nhưng kh&ocirc;ng c&oacute; kh&iacute; quyển. Kh&ocirc;ng giống sao Hỏa, nơi t&agrave;u vũ trụ c&oacute; thể bay đến điểm hạ c&aacute;nh v&agrave; giảm tốc bằng d&ugrave;, việc hạ c&aacute;nh xuống Mặt Trăng phụ thuộc ho&agrave;n to&agrave;n v&agrave;o động cơ. Nếu chỉ c&oacute; một động cơ duy nhất, giống như đa số t&agrave;u thăm d&ograve; nhỏ, th&igrave; n&oacute; phải chỉnh hướng được v&igrave; kh&ocirc;ng c&oacute; c&aacute;ch n&agrave;o kh&aacute;c để kiểm so&aacute;t qu&aacute; tr&igrave;nh hạ độ cao. Động cơ cũng phải c&oacute; van tiết lưu, cho ph&eacute;p điều chỉnh lực đẩy.</p>\n<div class=\"action_thumb flexbox\">&nbsp;</div>\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=SdnAPr1NL7eGOA_LcLxuNQ 1x, https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=cS7Pcqq6FnOAyhi1yksdWQ 1.5x, https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=VRZXTaKiEXQdx-e_unsLvQ 2x\" srcset=\"https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=SdnAPr1NL7eGOA_LcLxuNQ 1x, https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=cS7Pcqq6FnOAyhi1yksdWQ 1.5x, https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=VRZXTaKiEXQdx-e_unsLvQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=SdnAPr1NL7eGOA_LcLxuNQ\" alt=\"Phi h&agrave;nh gia Buzz Aldrin đứng c&ugrave;ng l&aacute; cờ Mỹ tr&ecirc;n Mặt Trăng trong nhiệm vụ Apollo 11 v&agrave;o th&aacute;ng 7/1969. Ảnh: NASA\" data-src=\"https://i1-vnexpress.vnecdn.net/2024/01/14/Mat-trang-do-bo-PHG-4549-1705166193.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=SdnAPr1NL7eGOA_LcLxuNQ\" data-ll-status=\"loaded\" /></div>\n<p class=\"Image\">Phi h&agrave;nh gia Buzz Aldrin đứng c&ugrave;ng l&aacute; cờ Mỹ tr&ecirc;n Mặt Trăng trong nhiệm vụ Apollo 11 v&agrave;o th&aacute;ng 7/1969. Ảnh:&nbsp;<em>NASA</em></p>', 6, 'fb6435cb97.jpg', 0),
(6, 'Công Vinh: \'Việt Nam được nhiều hơn mất dù thua Nhật Bản\'', '<p><span>Theo cựu tiền đạo L&ecirc; C&ocirc;ng Vinh, thầy tr&ograve; HLV Philippe Troussier thu hoạch nhiều điều t&iacute;ch cực d&ugrave; thất bại 2-4 trước Nhật Bản ở trận ra qu&acirc;n Asian Cup 2023.</span></p>', '<p><span>Trước Nhật Bản đạt phong độ cao nhất thế giới v&agrave; sở hữu 20 cầu thủ đang thi đấu ở ch&acirc;u &Acirc;u, Việt Nam được dự b&aacute;o c&oacute; thể đại bại. Trong 10 trận gần nhất, đội tuyển xứ mặt trời mọc ghi trung b&igrave;nh 4,5 b&agrave;n mỗi trận - trong đ&oacute; c&oacute; chiến thắng giao hữu 4-1 trước Đức.</span></p>', 5, 'facecf7d5a.jpg', 0),
(7, 'Màn rượt đuổi tỷ số của Việt Nam trước Nhật Bản', '<p><span>Bị đ&aacute;nh gi&aacute; thấp hơn rất nhiều, nhưng Việt Nam ghi hai b&agrave;n v&agrave; c&ugrave;ng Nhật Bản tạo n&ecirc;n hiệp một hấp dẫn nhất từ đầu Asian Cup 2023.</span></p>', '<p><span>Tr&ecirc;n s&acirc;n Al Thumama tối 14/1, Việt Nam (&aacute;o đỏ) bị đ&aacute;nh gi&aacute; thấp hơn nhiều so với Nhật Bản - đội b&oacute;ng số một ch&acirc;u &Aacute; v&agrave; đang sở hữu phong độ cao nhất thế giới cấp đội tuyển với 10 chiến thắng li&ecirc;n tiếp.</span></p>', 5, '47f94b351d.jpg', 0),
(8, 'Ancelotti: \'Real không ra sân để rửa hận Barca\'', '<p><span>Theo HLV Carlo Ancelotti, trận chung kết Si&ecirc;u Cup T&acirc;y Ban Nha giữa Real Madrid v&agrave; Barca sẽ được định đoạt bởi những chi tiết nhỏ.</span></p>', '<p class=\"Normal\">\"Real kh&ocirc;ng ra s&acirc;n để trả th&ugrave;\", Ancelotti nhấn mạnh khi được hỏi về thất bại tại Si&ecirc;u Cup m&ugrave;a trước . \"Ch&uacute;ng t&ocirc;i ra s&acirc;n với đầy đủ sức mạnh theo y&ecirc;u cầu việc kho&aacute;c &aacute;o Real. Ch&uacute;ng t&ocirc;i t&ocirc;n trọng đối thủ, nhưng lu&ocirc;n kh&aacute;t khao danh hiệu. Ch&uacute;ng t&ocirc;i rất gần việc đoạt danh hiệu đầu ti&ecirc;n của m&ugrave;a giải v&agrave; sẽ cố gắng l&agrave;m được điều đ&oacute;\".</p>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=H14sSn_blFOjqT35vZsPeg 1x, https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=2iQjfwSjbyhVDoSTOdmIrA 1.5x, https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=8jKiLFLNQfTaFQjSF25RxA 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=H14sSn_blFOjqT35vZsPeg 1x, https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=2iQjfwSjbyhVDoSTOdmIrA 1.5x, https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=8jKiLFLNQfTaFQjSF25RxA 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=H14sSn_blFOjqT35vZsPeg\" alt=\"HLV Ancelotti theo d&otilde;i buổi tập của Real tr&ecirc;n s&acirc;n Al Awwal, Riyadh ng&agrave;y 13/12. Ảnh: Reuters\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/14/carlo-jpeg-1705213093-7889-1705213243.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=H14sSn_blFOjqT35vZsPeg\" data-ll-status=\"loaded\" data-adbro-processed=\"true\" />\r\n<div class=\"embed-container-ads\">\r\n<div id=\"sis_inimage\" data-google-query-id=\"CO2YxMvG3YMDFYlBwgUdCYQBwg\">\r\n<div id=\"google_ads_iframe_/27973503/Vnexpress/Desktop/Inimage/Thethao/Thethao.bongda.detail_0__container__\"><iframe id=\"google_ads_iframe_/27973503/Vnexpress/Desktop/Inimage/Thethao/Thethao.bongda.detail_0\" title=\"3rd party ad content\" name=\"google_ads_iframe_/27973503/Vnexpress/Desktop/Inimage/Thethao/Thethao.bongda.detail_0\" frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" width=\"1\" height=\"1\" data-load-complete=\"true\" data-google-container-id=\"4\"></iframe></div>\r\n</div>\r\n</div>\r\n</div>\r\n<p class=\"Image\">HLV Ancelotti theo d&otilde;i buổi tập của Real tr&ecirc;n s&acirc;n Al Awwal, Riyadh ng&agrave;y 13/12. Ảnh:&nbsp;<em>Reuters</em></p>\r\n<p class=\"Normal\">Ở b&aacute;n kết, Real thắng ngược nghẹt thở 5-3 trước CLB c&ugrave;ng th&agrave;nh phố Atletico. Kh&aacute;c biệt được tạo ra ở hai hiệp phụ khi hai cầu thủ v&agrave;o s&acirc;n thay người muộn của Real đều tỏa s&aacute;ng. Tiền đạo Joselu đ&aacute;nh đầu n&acirc;ng tỷ số l&ecirc;n 4-2, rồi Brahim Diaz bứt tốc, dứt điểm v&agrave;o lưới trống ở ph&uacute;t b&ugrave; thứ hai của hiệp phụ thứ hai, ấn định chiến thắng 5-3.</p>', 5, '12191a288a.jpg', 0),
(10, 'Asian Cup 2023 bắt đầu', '<p><span>Lễ khai mạc Asian Cup 2023 với chủ đề \"Chương thất lạc của Kelileh v&agrave; Demneh\" kết th&uacute;c sau 25 ph&uacute;t, với th&ocirc;ng điệp ủng hộ Palestine từ chủ nh&agrave;.</span></p>', '<p class=\"Normal\">Lễ khai mạc cũng kh&ocirc;ng c&oacute; nhiều tiếng h&eacute;t từ kh&aacute;n giả như tại World Cup 2022, trong khi kh&aacute;n đ&agrave;i cũng c&oacute; nhiều ghế trống so với sức chứa gần 89.000 kh&aacute;n giả. C&ocirc;ng nghệ nổi bật nhất tr&ecirc;n s&acirc;n khấu l&agrave; bốn m&agrave;n h&igrave;nh động lớn c&oacute; h&igrave;nh d&aacute;ng giống s&acirc;n Lusail thu nhỏ, đặt cạnh nhau. Điểm hạn chế của chương tr&igrave;nh l&agrave; c&aacute;c tiết mục ho&agrave;n to&agrave;n bằng tiếng Arab, kh&ocirc;ng c&oacute; phi&ecirc;n dịch tiếng Anh.</p>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hz5zozzQrmeSbs3-L62TSg 1x, https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=RK0iEks1C8ayUHs81U0d3Q 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=qgE7tdRrpj4OU8-QL0Vrqg 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hz5zozzQrmeSbs3-L62TSg 1x, https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=RK0iEks1C8ayUHs81U0d3Q 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=qgE7tdRrpj4OU8-QL0Vrqg 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hz5zozzQrmeSbs3-L62TSg\" alt=\"M&ocirc; h&igrave;nh chiếc Cup xuất hiện tr&ecirc;n s&acirc;n trong lễ khai mạc tối 12/1. Ảnh: L&acirc;m Thoả\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/13/c8bbae62-853a-4b3a-8ef4-f97ee1-9031-6092-1705081497.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hz5zozzQrmeSbs3-L62TSg\" data-ll-status=\"loaded\" /></div>\r\n<p class=\"Image\">M&ocirc; h&igrave;nh chiếc Cup xuất hiện tr&ecirc;n s&acirc;n trong lễ khai mạc tối 12/1. Ảnh:&nbsp;<em>L&acirc;m Thoả</em></p>\r\n<p class=\"Normal\">Sau c&aacute;c tiết mục nghệ thuật hướng về chủ nh&agrave; v&agrave; Asian Cup, ban tổ chức sắp xếp những chương tr&igrave;nh v&igrave; Palestine. Đầu ti&ecirc;n l&agrave; m&agrave;n tuy&ecirc;n thệ của đội trưởng Qatar (Hassan Al-Haydos) v&agrave; Palestine (Musab Al-Batat). Đối thủ của Qatar trong trận khai mạc l&agrave; Lebanon, nhưng Al-Batat xuất hiện như một động th&aacute;i ủng hộ của chủ nh&agrave; với đất nước đang chịu cảnh chiến tranh ở Gaza. Cuối chương tr&igrave;nh, một nữ nghệ sĩ mặc bộ quần &aacute;o abaya m&agrave;u trắng truyền thống Arab, h&aacute;t một phần quốc ca Palestine.</p>', 5, '0b166ab56a.jpg', 0),
(11, 'Man Utd rơi chiến thắng trước Tottenham', '<p><span>Hai lần dẫn trước, Man Utd vẫn bị đội kh&aacute;ch Tottenham cầm h&ograve;a 2-2 ở v&ograve;ng 21 Ngoại hạng Anh</span></p>', '<p class=\"Normal\">Trong ng&agrave;y tỷ ph&uacute; Jim Ratcliffe đến s&acirc;n Old Trafford lần đầu kể từ khi nắm quyền điều h&agrave;nh c&aacute;c hoạt động b&oacute;ng đ&aacute;, Man Utd kh&ocirc;ng được hưởng niềm vui trọn vẹn. Tiền đạo Rasmus Hojlund mở tỷ số sớm, nhưng trung phong Richarlison gỡ h&ograve;a ngay trong hiệp một với c&uacute; đ&aacute;nh đầu từ t&igrave;nh huống cố định. Man Utd lại vượt l&ecirc;n nhờ c&ocirc;ng của Marcus Rashford, nhưng h&agrave;ng thủ lỏng lẻo khiến chủ nh&agrave; rơi hai điểm từ c&uacute; s&uacute;t cận th&agrave;nh của Rodrigo Bentancur.</p>\r\n<div class=\"action_thumb flexbox\">&nbsp;</div>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=5PS96OYmScRLU0z6cdMWPA 1x, https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=76TB_HUtp3AJSilqUK7CHw 1.5x, https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=QdCWUbrd1vUOE2aJgXSQLA 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=5PS96OYmScRLU0z6cdMWPA 1x, https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=76TB_HUtp3AJSilqUK7CHw 1.5x, https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=QdCWUbrd1vUOE2aJgXSQLA 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=5PS96OYmScRLU0z6cdMWPA\" alt=\"Tiền đạo Richarlison (tr&aacute;i) đ&aacute;nh đầu gỡ h&ograve;a cho Tottenham. Ảnh: Reuters\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/15/man-utd-jpeg-1705254350-9394-1705254379.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=5PS96OYmScRLU0z6cdMWPA\" data-ll-status=\"loaded\" /></div>\r\n<div>&nbsp;</div>', 5, '9d03b2f552.jpg', 0),
(12, 'De Bruyne giúp Man City thắng ngược Newcastle', '<p><span>Kevin de Bruyne v&agrave;o s&acirc;n từ ph&uacute;t 69, rồi ghi b&agrave;n v&agrave; kiến tạo đẹp mắt gi&uacute;p Man City thắng ngược chủ nh&agrave; Newcastle 3-2, v&ograve;ng 21 Ngoại hạng Anh.</span></p>', '<p class=\"Normal\">Newcastle dẫn ngược 2-1 với hai b&agrave;n trong v&ograve;ng hai ph&uacute;t, nhưng cục diện trận đấu thay đổi kể từ khi De Bruyne v&agrave;o s&acirc;n. Ng&ocirc;i sao người Bỉ chỉ mất năm ph&uacute;t để gỡ h&ograve;a, trước khi anh kiến tạo cho tiền vệ 21 tuổi Oscar Bobb ấn định thắng lợi 3-2 cho đương kim v&ocirc; địch ở ph&uacute;t b&ugrave; hiệp hai.</p>\r\n<div class=\"action_thumb flexbox\">&nbsp;</div>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1Upjo7sxN8rVLUivmPDVkQ 1x, https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=_Be0E-D3VhRknQPIi7_fQg 1.5x, https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=9hRYgA6k_yZ4TteaSjhaZQ 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1Upjo7sxN8rVLUivmPDVkQ 1x, https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=_Be0E-D3VhRknQPIi7_fQg 1.5x, https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=9hRYgA6k_yZ4TteaSjhaZQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1Upjo7sxN8rVLUivmPDVkQ\" alt=\"De Bruyne (phải) mừng b&agrave;n gỡ h&ograve;a 2-2 cho Man City trước Newcastle tr&ecirc;n s&acirc;n St James Park, hạt Tyne and Wear, v&ograve;ng 21 Ngoại hạng Anh ng&agrave;y 13/1/2024. Ảnh: Reuters\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/14/de-bruyne-jpeg-1705176182-2637-1705176342.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1Upjo7sxN8rVLUivmPDVkQ\" data-ll-status=\"loaded\" />\r\n<div class=\"embed-container-ads\">&nbsp;</div>\r\n</div>\r\n<p class=\"Image\">De Bruyne (phải) mừng b&agrave;n gỡ h&ograve;a 2-2 cho Man City trước Newcastle tr&ecirc;n s&acirc;n St James Park, hạt Tyne and Wear, v&ograve;ng 21 Ngoại hạng Anh ng&agrave;y 13/1/2024. Ảnh:&nbsp;<em>Reuters</em></p>', 5, 'd2990463b1.jpg', 0),
(13, 'Chelsea vượt mặt Man Utd', '<p><span>Pha đ&aacute; phạt đền th&agrave;nh c&ocirc;ng của tiền vệ 21 tuổi Cole Palmer gi&uacute;p Chelsea hạ Fulham 1-0 ở v&ograve;ng 21 Ngoại hạng Anh.</span></p>', '<p class=\"Normal\">Đ&acirc;y l&agrave; chiến thắng thứ tư li&ecirc;n tiếp tr&ecirc;n s&acirc;n nh&agrave; của Chelsea t&iacute;nh tr&ecirc;n mọi đấu trường, gi&uacute;p họ tho&aacute;t khỏi vị tr&iacute; thứ 10 quen thuộc. Thầy tr&ograve; Mauricio Pochettino vượt qua Newcastle v&agrave; Man Utd để leo l&ecirc;n thứ t&aacute;m với 31 điểm, k&eacute;m top bốn ch&iacute;n điểm.</p>\r\n<div class=\"action_thumb flexbox\">&nbsp;</div>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=r7VLtnLlD5n0BgxRAqHC8w 1x, https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=TiYg4j-shv3E26hhGj8fbw 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=pqUDceuMlyGdC9-1Rp_Qvg 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=r7VLtnLlD5n0BgxRAqHC8w 1x, https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=TiYg4j-shv3E26hhGj8fbw 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=pqUDceuMlyGdC9-1Rp_Qvg 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=r7VLtnLlD5n0BgxRAqHC8w\" alt=\"Palmer đ&aacute; phạt đền, ghi b&agrave;n trong thời gian b&ugrave; giờ hiệp một. Ảnh: Reuters\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/13/Screenshot-2024-01-13-at-22-05-9054-7962-1705158759.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=r7VLtnLlD5n0BgxRAqHC8w\" data-ll-status=\"loaded\" />\r\n<div class=\"embed-container-ads\">&nbsp;</div>\r\n</div>\r\n<p class=\"Image\">Palmer đ&aacute; phạt đền, ghi b&agrave;n trong thời gian b&ugrave; giờ hiệp một. Ảnh:&nbsp;<em>Reuters</em></p>\r\n<div><em><br /></em></div>', 5, '3f63d9dc6c.png', 0),
(14, 'Tottenham đón cú hích chuyển nhượng trước khi đấu Man Utd', '<p><span>Trước trận gặp Man Utd ở v&ograve;ng 21 Ngoại hạng Anh, HLV Ange Postecoglou h&agrave;i l&ograve;ng khi Tottenham sớm mang về c&aacute;c mục ti&ecirc;u Timo Werner v&agrave; Radu Dragusin.</span></p>', '<p class=\"Normal\">Theo HLV người Australia, việc ban huấn luyện c&ugrave;ng ban l&atilde;nh đạo thống nhất c&aacute;c mục ti&ecirc;u v&agrave; l&agrave;m việc đồng bộ gi&uacute;p đẩy nhanh qu&aacute; tr&igrave;nh chuyển nhượng. &Ocirc;ng cũng xem việc sớm chốt hợp đồng sẽ gi&uacute;p Timo Werner v&agrave; Radu Dragusin c&oacute; th&ecirc;m thời gian h&ograve;a nhập với đội.</p>\r\n<div class=\"action_thumb flexbox\">&nbsp;</div>\r\n<div class=\"fig-picture\"><source data-srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=es0guLh4n6MKe_xJBrD0iw 1x, https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=emDeB2GMkzCW3PuKd-hVRA 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=dZDtfo7fJSYxkmJhlJRWKQ 2x\" srcset=\"https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=es0guLh4n6MKe_xJBrD0iw 1x, https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=emDeB2GMkzCW3PuKd-hVRA 1.5x, https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=dZDtfo7fJSYxkmJhlJRWKQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=es0guLh4n6MKe_xJBrD0iw\" alt=\"HLV Ange Postecoglou cảm ơn người h&acirc;m mộ Tottenham sau trận tiếp Newcastle ở Ngoại hạng Anh ng&agrave;y 10/12/2013. Ảnh: Reuters\" data-src=\"https://i1-thethao.vnecdn.net/2024/01/13/2023-12-10T182925Z-128014911-U-3055-5031-1705162171.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=es0guLh4n6MKe_xJBrD0iw\" data-ll-status=\"loaded\" />\r\n<div class=\"embed-container-ads\">&nbsp;</div>\r\n</div>\r\n<p class=\"Image\">HLV Ange Postecoglou cảm ơn người h&acirc;m mộ Tottenham sau trận tiếp Newcastle ở Ngoại hạng Anh ng&agrave;y 10/12/2013. Ảnh:&nbsp;<em>Reuters</em></p>', 5, '92c5e41faa.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brandId` int NOT NULL,
  `brandName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`brandId`, `brandName`) VALUES
(1, 'Acer'),
(2, 'Samsung'),
(3, 'Oppo'),
(4, 'Apple');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cartId` int NOT NULL,
  `productId` int NOT NULL,
  `sId` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catId` int NOT NULL,
  `catName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catId`, `catName`) VALUES
(1, 'Laptop'),
(2, 'Modem Wifi'),
(3, 'Phone'),
(4, 'Tivi'),
(5, 'Camera');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_post`
--

CREATE TABLE `tbl_category_post` (
  `id_cate_post` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_post` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category_post`
--

INSERT INTO `tbl_category_post` (`id_cate_post`, `title`, `desc_post`, `status`) VALUES
(3, 'Tin công nghệ', 'Tin công nghệ cập nhật hằng ngày thường xuyên', 0),
(4, 'Tin kinh doanh', 'Tin kinh doanh hot', 0),
(5, 'Tin thể thao', 'Tin thể thao cập nhật hằng ngày nóng hổi', 0),
(6, 'Tin khoa học', 'Tin khoa học cập nhật thường xuyên', 0),
(7, 'Tin game', 'Tin game cập nhật hằng ngày', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_compare`
--

CREATE TABLE `tbl_compare` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `productId` int NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int NOT NULL,
  `productId` int NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paymentMethod` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `order_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `productId`, `productName`, `user_id`, `quantity`, `price`, `image`, `date_order`, `paymentMethod`, `order_code`) VALUES
(84, 4, 'Máy ảnh Cannon', 1, 10, '1000', '43f9b85f2b.jpg', '2024-01-21 21:12:44', 'offline', '6394'),
(85, 10, 'Tivi', 6, 1, '1500', '91f49a00b8.jpg', '2024-02-20 11:38:18', 'momo_wallet', '2743'),
(91, 8, 'Áo đen tây', 1, 1, '2200', 'ff292f5007.jpg', '2024-02-20 14:50:22', 'offline', '3097'),
(92, 10, 'Tivi', 6, 3, '1500', '91f49a00b8.jpg', '2024-02-20 14:58:26', 'offline', '6874'),
(93, 8, 'Áo đen tây', 6, 2, '2200', 'ff292f5007.jpg', '2024-02-20 15:02:19', 'offline', '1382'),
(94, 2, 'Iphone 5', 1, 15, '2000', 'f13818c57c.png', '2024-02-20 15:34:51', 'offline', '3528'),
(95, 10, 'Tivi', 1, 3, '1500', '91f49a00b8.jpg', '2024-02-20 15:55:48', 'offline', '4482'),
(96, 10, 'Tivi', 1, 2, '1500', '91f49a00b8.jpg', '2024-02-20 15:59:44', 'offline', '4856'),
(97, 1, 'Laptop Samsung', 1, 5, '1500', 'dbde6663aa.jpg', '2024-03-07 19:29:40', 'offline', '5041'),
(98, 10, 'Tivi', 18, 1, '1500', '91f49a00b8.jpg', '2024-03-20 04:02:34', 'offline', '6774'),
(99, 4, 'Máy ảnh Cannon', 18, 3, '1000', '43f9b85f2b.jpg', '2024-03-20 04:05:58', 'momo_wallet', '3846');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_placed`
--

CREATE TABLE `tbl_placed` (
  `id_placed` int NOT NULL,
  `order_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `user_id` int NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_placed`
--

INSERT INTO `tbl_placed` (`id_placed`, `order_code`, `status`, `user_id`, `date_created`) VALUES
(34, '2743', 2, 6, '2024-02-20'),
(36, '3097', 2, 1, '2024-02-20'),
(37, '6874', 2, 6, '2024-02-20'),
(38, '1382', 2, 6, '2024-02-20'),
(39, '3528', 2, 1, '2024-02-20'),
(40, '4482', 2, 1, '2024-02-20'),
(41, '4856', 2, 1, '2024-02-20'),
(42, '5041', 0, 1, '2024-03-08'),
(43, '6774', 2, 18, '2024-03-20'),
(44, '3846', 1, 18, '2024-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `productId` int NOT NULL,
  `productName` tinytext COLLATE utf8mb4_general_ci NOT NULL,
  `product_quantity` int NOT NULL,
  `product_soldcount` int NOT NULL DEFAULT '0',
  `product_remain` int NOT NULL,
  `catId` int NOT NULL,
  `brandId` int NOT NULL,
  `product_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` int NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`productId`, `productName`, `product_quantity`, `product_soldcount`, `product_remain`, `catId`, `brandId`, `product_desc`, `type`, `price`, `image`) VALUES
(1, 'Laptop Samsung', 10, 0, 10, 1, 2, '<p>Đẹp rẻ</p>', 1, '1500', 'dbde6663aa.jpg'),
(4, 'Máy ảnh Cannon', 20, 10, 10, 5, 1, '<p>Bền rẻ</p>', 1, '1000', '43f9b85f2b.jpg'),
(5, 'Máy ảnh Cannon 2', 10, 0, 10, 5, 4, '<p>Rẻ đẹp</p>', 0, '1500', '58c54eaed9.png'),
(6, 'Camera SealPea', 0, 0, 0, 5, 2, '<p>Đẹp xịn</p>', 1, '1500', 'e68b27b91e.jpg'),
(10, 'Tivi', 10, 10, 0, 4, 2, '<p>Đẹp rẻ</p>', 1, '1500', '91f49a00b8.jpg'),
(14, 'Iphone 14 Pro Max Đen', 10, 0, 10, 3, 4, '<p>Sang trọng,...</p>', 1, '2000', '4c30ad8316.jpg'),
(15, 'Iphone 14 Pro Max Tím', 30, 0, 30, 3, 4, '<p>Sang trọng,...</p>', 1, '2500', '082a2f9f5d.webp'),
(16, 'Iphone 14 Pro Max Vàng', 15, 0, 15, 3, 4, '<p>Sang trọng,....</p>', 1, '2000', 'e765a65013.jpg'),
(17, 'Iphone 14 Plus Max Trắng', 50, 0, 50, 3, 4, '<p>Sang trọng,...</p>', 1, '2000', '6851adc319.webp'),
(18, 'Iphone 14 Plus Max Đỏ', 10, 0, 10, 3, 4, '<p>T&iacute;m phong c&aacute;ch,...</p>', 1, '2100', '14118903ec.webp'),
(19, 'Iphone 14 Plus ', 10, 0, 10, 3, 4, '<p>Xanh dương bao đẹp,...</p>', 1, '2300', 'eddfb984e4.webp'),
(20, 'Iphone 14 Pro Max Đen', 25, 0, 25, 3, 4, '<p>Đen qu&yacute; ph&aacute;i</p>', 1, '2300', 'f309340d2d.webp'),
(21, 'Iphone 14 Plus Max Hồng', 20, 0, 20, 3, 4, '<p>Hồng nhẹ nh&agrave;ng</p>', 1, '2500', '1da3095172.webp'),
(22, 'RouterWifi Acer', 15, 0, 15, 2, 1, '<p>Khoảng c&aacute;ch xa</p>', 0, '1000', 'f3ddb6a282.jpg'),
(23, 'RouterWifi samsung', 10, 0, 10, 2, 2, '<p>Lần đầu xuất hiện tr&ecirc;n thị trường</p>', 0, '1200', 'd39451a407.jpg'),
(24, 'RouterWifi Oppo', 10, 0, 10, 2, 3, '<p>M&agrave;u trắng sang trọng ph&ugrave; hợp với nhiều nh&agrave;</p>', 1, '1300', '81bd4eb84d.jpg'),
(25, 'RouterWifi Apple', 10, 0, 10, 2, 4, '<p>Bao xịn</p>', 0, '1500', '1e9779e666.jpg'),
(26, 'TiVi Acer', 10, 0, 10, 4, 1, '<p>Nhẹ rẻ khỏe</p>', 0, '2000', '5133aa996f.jpg'),
(27, 'TiVi Apple', 10, 0, 10, 4, 4, '<p>Mới ra mắt v&agrave;o năm 2024</p>', 1, '2400', '6bf6df14cf.jpg'),
(28, 'TiVi Oppo', 15, 0, 15, 4, 3, '<p>Sản phẩm đến từ nh&agrave; Oppo</p>', 0, '2200', 'e11657993a.jpg'),
(29, 'TiVi Samsung', 20, 0, 20, 4, 2, '<p>Chất lượng đi đ&ocirc;i với số lượng</p>', 1, '2500', '528c6700b5.jpg'),
(30, 'Maxbook Pro ME864', 15, 0, 15, 1, 4, '<p>Maxbook một sản phẩm nổi tiếng từ nh&agrave; Apple</p>', 1, '3000', '5733e4581d.jpg'),
(31, 'Book Pro Samsung', 10, 0, 10, 1, 2, '<p>Si&ecirc;u đỉnh</p>', 1, '2500', 'af5dfa4f27.png'),
(32, 'Pad 2 Oppo', 10, 0, 10, 1, 3, '<p>Giả laptop</p>', 0, '2300', '7709c732c7.jpg'),
(33, 'Aspire 3 Acer', 10, 0, 10, 1, 1, '<p>D&agrave;nh cho c&aacute;c game thủ</p>', 0, '2700', '5d7ea28f37.jpg'),
(34, 'Camera 8K Apple', 10, 0, 10, 5, 4, '<p>Qu&aacute; đ&atilde;</p>\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 7px; top: 20.5556px;\">&nbsp;</div>', 1, '2100', '40eef876c6.jpeg'),
(35, 'Camera acer', 10, 0, 10, 5, 1, '<p>D&agrave;nh cho game thủ</p>', 0, '2300', '4246f0d1fa.jpg'),
(36, 'Camera Oppo', 20, 0, 20, 5, 3, '<p>Oppo sản xuất camera :))</p>', 1, '2500', 'b0b96ab7ad.jpg'),
(37, 'Camera Samsung', 10, 0, 10, 5, 2, '<p>độc lạ chưa từng c&oacute;</p>', 0, '3000', '18007f8bef.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `id` int NOT NULL,
  `rating` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`id`, `rating`, `product_id`, `user_id`) VALUES
(27, 5, 6, 1),
(28, 5, 6, 3),
(29, 3, 6, 6),
(32, 5, 4, 1),
(33, 5, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Normal'),
(3, 'Writer\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `slider_id` int NOT NULL,
  `sliderName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slider_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`slider_id`, `sliderName`, `slider_image`, `type`) VALUES
(2, 'Slider2', '1c6e3624a6.jpg', 1),
(4, 'WinnerBigSale', '785120be6b.png', 1),
(5, 'Promax14', '4aef4b2399.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thongke`
--

CREATE TABLE `tbl_thongke` (
  `id_thongke` int NOT NULL,
  `doanhthu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `soluong` int NOT NULL,
  `date_thongke` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_thongke`
--

INSERT INTO `tbl_thongke` (`id_thongke`, `doanhthu`, `soluong`, `date_thongke`) VALUES
(18, '11000', 10, '2024-01-21'),
(19, '79310', 37, '2024-02-20'),
(20, '1650', 1, '2024-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `productId` int NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`id`, `user_id`, `productId`, `productName`, `price`, `image`) VALUES
(3, 1, 9, 'Áo đen tây nam', '2400', '93ca9f6ac8.jpg'),
(4, 18, 10, 'Tivi', '1500', '91f49a00b8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `isConfirmed` tinyint NOT NULL,
  `captcha` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `dob`, `password`, `role_id`, `address`, `isConfirmed`, `captcha`) VALUES
(1, 'pokemon@gmail.com', 'Thanh Dat', '2024-01-01', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Cần Thơ', 1, '94081'),
(3, 'pikachu@gmail.com', 'Nhut Linh', '2024-01-04', 'e10adc3949ba59abbe56e057f20f883e', 2, 'CanTho', 1, '78014'),
(4, 'admin@gmail.com', 'admin', '2024-01-04', 'e10adc3949ba59abbe56e057f20f883e', 1, 'Cần Thơ', 1, '12345'),
(6, 'khunglong@gmail.com', 'Huu Tai', '2024-01-06', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Can Tho', 1, '53004'),
(10, 'khunglong123@gmail.com', 'Huu Tai ', '2024-01-03', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Can Tho ', 1, '53002'),
(13, 'xinhxinh123@gmail.com', 'Xinh xinh', '2024-01-04', 'e10adc3949ba59abbe56e057f20f883e', 1, 'Can Tho', 1, '53238'),
(15, 'xinhxan@gmail.com', 'Xinh xan', '2024-01-05', 'e10adc3949ba59abbe56e057f20f883e', 3, 'Can Tho , NK', 1, '79779'),
(18, 'huulinh12@gmail.com', 'Huu Linh', '2024-03-01', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Can Tho', 1, '29533'),
(20, 'duongphamminh2408@gmail.com', 'Phạm Đương', '2024-04-01', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Cần Thơ', 1, '22354');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  ADD PRIMARY KEY (`binhluan_id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brandId`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cartId`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catId`);

--
-- Indexes for table `tbl_category_post`
--
ALTER TABLE `tbl_category_post`
  ADD PRIMARY KEY (`id_cate_post`);

--
-- Indexes for table `tbl_compare`
--
ALTER TABLE `tbl_compare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_placed`
--
ALTER TABLE `tbl_placed`
  ADD PRIMARY KEY (`id_placed`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  ADD PRIMARY KEY (`id_thongke`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_binhluan`
--
ALTER TABLE `tbl_binhluan`
  MODIFY `binhluan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brandId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cartId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_category_post`
--
ALTER TABLE `tbl_category_post`
  MODIFY `id_cate_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_compare`
--
ALTER TABLE `tbl_compare`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tbl_placed`
--
ALTER TABLE `tbl_placed`
  MODIFY `id_placed` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `productId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `slider_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  MODIFY `id_thongke` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
