-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2020 at 02:00 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `email`) VALUES
(1, 'Admin', 'admin', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `heading` varchar(500) NOT NULL,
  `sub_heading` varchar(500) NOT NULL,
  `link` varchar(100) NOT NULL,
  `link_text` varchar(100) NOT NULL,
  `banner_serial_number` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `heading`, `sub_heading`, `link`, `link_text`, `banner_serial_number`, `status`, `added_on`) VALUES
(2, '612548828_slider_2.jpg', 'Drink & Healthy Food', 'Fresh Healthy and Organic', 'shop', 'Order Now', 2, 1, '2020-08-18 06:44:20'),
(3, '265489366_slider_1.jpg', 'Drink & Healthy Food', 'Fresh Healthy and Organic.', 'shop', 'Order Now', 1, 1, '2020-08-18 10:03:57'),
(4, '342664930_slider_3.jpg', 'Drink & Healthy Food', 'Fresh Healthy and Organic.', 'shop', 'Order Now', 3, 1, '2020-08-18 10:04:35'),
(5, '698160807_slider_4.jpg', 'Drink & Healthy Food', 'Fresh Healthy and Organic.', 'shop', 'Order Now', 4, 1, '2020-08-18 10:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `order_number` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `order_number`, `status`, `added_on`) VALUES
(1, 'Drinks', 103, 1, '2020-08-13 02:31:40'),
(3, 'Chinese', 101, 1, '2020-08-15 01:27:55'),
(4, 'Indian', 102, 1, '2020-08-15 04:13:11'),
(5, 'Italian', 104, 1, '2020-08-16 02:49:47'),
(6, 'Bengali', 105, 1, '2020-08-16 02:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile`, `subject`, `message`, `added_on`) VALUES
(2, 'Juwel Rana', 'juwel@gmail.com', '01713245678', 'Dish Problem', 'My order dish is not good.', '2020-08-19 10:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_master`
--

CREATE TABLE `coupon_master` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_type` enum('P','F') NOT NULL,
  `coupon_value` int(11) NOT NULL,
  `cart_min_value` int(11) NOT NULL,
  `expired_on` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_master`
--

INSERT INTO `coupon_master` (`id`, `coupon_code`, `coupon_type`, `coupon_value`, `cart_min_value`, `expired_on`, `status`, `added_on`) VALUES
(2, 'First250', 'F', 250, 1250, '2020-09-10', 1, '2020-08-16 12:41:09'),
(3, 'First10', 'P', 10, 1000, '2020-08-25', 1, '2020-08-16 12:56:43'),
(5, 'First20', 'P', 20, 2500, '', 1, '2020-08-16 02:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_boy`
--

INSERT INTO `delivery_boy` (`id`, `name`, `mobile`, `password`, `status`, `added_on`) VALUES
(1, 'Shabbir Ahmed', '01712345643', '1234', 1, '2020-08-15 06:14:42'),
(2, 'Md. Emon Mollah', '01912345644', '12345', 1, '2020-08-15 09:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `dish_detail` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `type` enum('veg','non-veg') NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `categories_id`, `dish_name`, `dish_detail`, `image`, `type`, `status`, `added_on`) VALUES
(5, 1, 'PRAN Fruitix Mango', 'PRAN Drink', '659342447_1.jpg', 'veg', 1, '2020-08-17 10:02:59'),
(6, 6, 'Easy Chicken Dum Biryani', 'It\'s that time of the year, when festivity is in the air! And you cannot think of festivals without good food. Especially, it is impossible to imagine Eid without Biryani. So, here\'s a quick and easy recipe to satiate your cravings. It is such a versatile dish that various kinds of biryanis can be prepared using different vegetables and meats.', '625786675_2.jpg', 'non-veg', 1, '2020-08-31 05:49:12'),
(7, 6, 'Paratha', 'Paratha is an unleavened flatbread in Bangladesh made by baking flour dough on a frying pan and finishing off with shallow frying. It is layered by coating with oil and folding repeatedly using a laminated dough technique. It is the most popular Bangladeshi food for breakfast in the restaurants, which is normally eaten with vaji (mixed vegetable) or lentil or a mixture of these two together, and with fried eggs.', '651963975_3.jpg', 'veg', 1, '2020-09-07 10:59:52'),
(8, 6, 'Bhuna Khichuri', 'Bhuna Khichuri could be cooked with different types of meat &#8211; beef, mutton (goat), and chicken. Also, it can have eggs or prawn added to it. It is a very popular dish for lunch in traditional Bangladeshi restaurants.', '482286241_4.jpg', 'non-veg', 1, '2020-09-07 11:10:52'),
(9, 6, 'Haleem', 'Haleem is basically spicy lentil soup very popular in Bangladesh. Haleem is made of wheat, barley, meat (usually minced meat of beef or mutton), different types of lentils, spices, and sometimes rice is also used. This dish is slow-cooked for seven to eight hours, which results in a paste-like consistency, blending the flavors of spices, meat, barley, and wheat.', '973524305_5.jpg', 'non-veg', 1, '2020-09-07 11:19:12'),
(10, 6, 'Misti Doi - Sweet Yogurt', 'Misti Doi is made with milk and sugar or jaggery. It differs from the plain yogurt because of the technique of preparation. It is prepared by boiling milk until it is slightly thickened, sweetening it with sugar or jaggery, and allowing the milk to ferment overnight. Earthenware is always used as the container for making Misti Doi because the gradual evaporation of water through its porous walls not only further thickens the yogurt, but also produces the right temperature for the growth of the culture.', '790798611_6.jpg', 'non-veg', 1, '2020-09-07 11:24:31'),
(11, 6, 'Falooda', 'Falooda is a cold dessert very popular in Bangladesh. Traditionally it is made from mixing rose syrup, vermicelli, sweet basil (sabza/takmaria) seeds, and pieces of jelly with milk often topped off with a scoop of ice cream, lastly garnished with chopped fruits. The vermicelli used for preparing Falooda is made from wheat, arrowroot, cornstarch, or sago pearls.', '355441623_7.jpg', 'veg', 1, '2020-09-07 12:17:31'),
(12, 1, 'Borhani', 'Borhani balances the spiciness of the main food and it has ingredients like mint, cumin, and yogurt. It also helps digestion.', '940077039_8.jpg', 'veg', 1, '2020-09-07 12:26:42'),
(13, 1, 'Sweet Lassi', 'Lassi is a popular traditional yogurt-based drink from Bangladesh. Lassi is a blend of yogurt, water, spices, and sometimes fruit.', '654161241_9.jpg', 'veg', 1, '2020-09-07 12:30:02'),
(14, 6, 'Rasmalai', 'Rasmalai is a unique Bangladeshi delicacy. This Bangladeshi dessert is a flattened cheese ball soaked in malai (clotted cream) flavored with cardamom. Malai or clotted cream itself has a unique texture. Malai is made by heating non-homogenized whole milk to about 80 Â°C for about one hour and then allowing it to cool down. A thick yellowish layer of fat and coagulated proteins forms on the surface, which is skimmed off. The process is usually repeated to remove most of the fat.', '928276909_10.jpg', 'non-veg', 1, '2020-09-07 12:35:09'),
(15, 6, 'Fuchka', 'Fuchka is the most popular street food in Bangladesh, served mainly in the evening. It has a unique spicy, sour, crispy taste. It consists of a round, hollow puri, fried crisp and filled with a mixture of flavored water, tamarind chutney, chili, chaat masala, potato, onion, and chickpeas. Fuchka uses a mixture of boiled mashed potatoes as the filling and is tangy rather than sweetish while the water is sour and spicy.', '538709852_11.jpg', 'non-veg', 1, '2020-09-07 12:42:03'),
(16, 5, 'Caprese Salad with Pesto Sauce', 'This combination of juicy tomatoes and mozzarella cheese salad topped with freshly made pesto sauce is a distinct yet simple one. It offers a twist to the classic caprese salad.', '461507161_12.jpg', 'veg', 1, '2020-09-07 12:51:17'),
(17, 5, 'Panzenella', 'Panzenella is a Tuscan bread salad, ideal for summer. It does not follow a particular recipe, but the two ingredients that do not change are tomatoes and bread. This salad is great with a chilled glass of Prosecco and lots of sunshine!', '980794270_13.jpg', 'veg', 1, '2020-09-07 12:53:37'),
(18, 5, 'Bruschetta', 'An antipasto dish, bruschetta has grilled bread topped with veggies, rubbed garlic and tomato mix. A country bread sliced and topped with different toppings - the evergreen tomato-basil and an inventive mushroom-garlic. The classic Italian starter!', '471842447_14.jpg', 'veg', 1, '2020-09-07 12:56:57'),
(19, 5, 'Pasta Carbonara', 'This simple Roman pasta dish derives its name from \'carbone\' meaning coal. It was a pasta popular with the coal miners. The original recipe calls for guanciale, which is pig\'s cheek, but since its not easily available, the chef has used bacon instead.', '680826822_15.jpg', 'non-veg', 1, '2020-09-07 01:00:36'),
(20, 5, 'Mushroom Risotto', 'A plateful of buttery risotto with the goodness of mushrooms. A healthy bowl of mushroom risotto has benefits more than you can think. A great source of protein, powerful antioxidant and even has cancer-fighting properties. This risotto recipe with mushrooms is a delicious recipe besides being easy and quick! Great to feed a hungry horde!', '182373046_16.jpg', 'non-veg', 1, '2020-09-07 01:02:28'),
(21, 5, 'Pasta Con Pomodoro E Basilico', 'This is the most basic and simplest cooked pasta sauce, hence it is the benchmark of a good Italian home cook. This one boats of being among the original Italian recipes of pasta. easy and quick, this pasta recipe can be made under half an hour. Serve as a breakfast, pack for kid\'s tiffin or savour as an evening snack. You can even cook this for a casual and lazy dinner and pair this up with red wine.', '457031249_17.jpg', 'non-veg', 1, '2020-09-07 01:05:28'),
(22, 5, 'Panettone', 'An Italian sweet bread, panettone is a perfect Christmas or New year\'s dessert with the goodness of egg, flour, sugar, raisins, candied orange, lemon and cherries', '595730251_18.jpg', 'non-veg', 1, '2020-09-07 01:08:10'),
(23, 3, 'Dim Sums', 'Small bite-sized rounds stuffed with veggies or meat. Dimsums are perfect steamed snack to delight those evening cravings.', '366699218_19.jpg', 'non-veg', 1, '2020-09-07 01:13:24'),
(24, 3, 'Hot and Sour Soup', 'Isn\'t it great to warm up with a piping hot bowl of soup during the winters? Here is a soup with a spicy and sour broth. It is made with the goodness of mushrooms, cabbage, carrot and a spicy twist of red peppers or white pepper and sour with vinegar.', '949652777_20.jpg', 'non-veg', 1, '2020-09-07 01:15:01'),
(25, 3, 'Quick Noodles', 'One of the staples in every home, noodles are not just a kid\'s favourite snack to binge on but are also equally loved by adults. Here is a noodles recipe that is super quick and easy to prepare at home. Just bung in all your favourite veggies and create a masterpiece of your own.', '332872178_21.jpg', 'veg', 1, '2020-09-07 01:16:44'),
(26, 3, 'Szechwan Chilli Chicken', 'A fiery delight straight from the Sichuan region. It is loaded with pungent spices like brown pepper. red chillies, ginger, green chillies and white pepper.', '152343749_22.jpg', 'non-veg', 1, '2020-09-07 01:18:31'),
(27, 3, 'Spring Rolls', 'A crisp appetizer where shredded veggies are encased in thin sheets and then fried golden. Little munchies to prepare at home for a high tea menu or just a party starter, serve with a tangy dip.', '298502604_23.jpg', 'veg', 1, '2020-09-07 01:20:56'),
(28, 3, 'Cantonese Chicken Soup', 'Packed with bokchoy, mushrooms, spring onion and chicken, this heart-warming soup recipe is perfect for a chilly winter evening', '291476779_24.jpg', 'non-veg', 1, '2020-09-07 01:23:29'),
(29, 4, 'Palak Bhurji', 'A light and fresh palak recipe with a mild seasoning and some crushed paneer, perfect to team with piping hot phulkas. This is a healthy recipe with a delicious melange of spices', '406114366_25.jpg', 'veg', 1, '2020-09-07 01:26:01'),
(30, 4, 'Hyderabadi Baingan', 'Straight from the royal kitchens of Hyderabad comes an authentic brinjal curry. Small whole brinjals are doused in a nutty gravy made with peanuts, tamarind and sesame seeds. This is a mouth-watering dish to cook for lunch or dinner, the masala is so full of flavour that this can go well with anything from rice to roti.', '718126085_26.jpg', 'veg', 1, '2020-09-07 01:27:26'),
(31, 4, 'Gatte Ki Sabzi', 'This mouthwatering delight is a gift from the Rajasthani cuisine, full of spices and flavors. Gatte are basically cooked gram flour dumplings which are added to the spicy curd gravy. These can be served for lunch or a dinner party as the star vegetarian dish. Serve along with parathe or chapati.', '314181857_27.jpg', 'veg', 1, '2020-09-07 01:29:13'),
(32, 4, 'Allahabadi Tehri', 'A delicious one pot rice meal which originated in Uttar Pradesh. It\'s aromatic, filled with varied masalas and lots of vegetables. With a spoonful of ghee on top, this vegetarian rice recipe is a must try. Cook for lunch accompanied with curd.', '559678819_28.jpg', 'veg', 1, '2020-09-07 01:31:10'),
(33, 4, 'Gobhi Masaledaar', 'Gobhi is one of the staple food made in Indian homes. This Cauliflower recipe is cooked in a myriad of spices that makes it a delicious dish for lunch or tiffin to team with rotis or dal-chawal. You can make this for a quick lunch paired best with parathe or even at a dinner party as a side dish.', '821750216_29.jpg', 'veg', 1, '2020-09-07 01:33:26'),
(34, 4, 'Mutton Korma', 'A flavourful mutton curry, where the meat is stirred with curd, garlic-ginger paste, cloves, cardamom and cinnamon sticks.', '927218967_30.jpg', 'non-veg', 1, '2020-09-07 01:39:09'),
(35, 4, 'Pina Colada Pork Ribs', 'The ingredients of the popular rum-based cocktail team up with pork ribs to create a lip-smacking treat. Pork is slow roasted to soak in the flavours, and the kick of ginger gives it an interesting edge.', '391764322_31.jpg', 'non-veg', 1, '2020-09-07 01:40:30'),
(36, 4, 'Malabar Fish Biryani', 'This classic Malabar Fish Biryani can be devoured at all times. Enjoy the delicious taste of this ever-charming dish.', '554524739_32.jpg', 'non-veg', 1, '2020-09-07 01:41:54'),
(37, 4, 'Nihari Gosht', 'A traditional Muslim dish, where the meat almost blends with the gravy. Nihari traditionally means a slow cooked mutton stew, which is said o be originated in the Awadhi kitchen of Lucknow. A popular dish in Pakistan and Bangladesh, Nihari is also considered to be the national dish of Pakistan. The hint of rose water gives this a perfect finish.', '630343966_33.jpg', 'non-veg', 1, '2020-09-07 01:43:59'),
(38, 1, 'Americano', 'Americano is espresso and hot water made to be about the same strength and amount as a normal cup of drip coffee, but the process gives it a stronger, more intense flavor. It is made by diluting an espresso with boiling water. It is an Italian drink referred to as the â€œAmerican Coffee,â€ hence its name.', '818956163_34.jpg', 'veg', 1, '2020-09-07 01:49:45'),
(39, 1, 'CafÃ© mocha', 'Also called a mochaccino, the cafÃ© mocha is latte or traditional coffee with milk, made with chocolate flavoring. The name comes from its city of origin, Mocha, Yemen. As a twist from the traditional mocha, a white mocha is said to be Miley Cyrusâ€™s drink of choice.', '295545789_35.jpg', 'veg', 1, '2020-09-07 01:51:15'),
(40, 1, 'Carrot, clementine & pineapple juice', 'Sweet, tangy and fresh, this bright orange juice will give you a morning boost', '195149739_36.jpg', 'veg', 1, '2020-09-07 01:53:49'),
(41, 1, 'Fennel, blueberry & apple juice', 'Fresh vegetable and fruit juice is a great morning pick-me-up, packed with nutrients such as folate, fibre and vitamin C', '578423394_37.jpg', 'veg', 1, '2020-09-07 01:55:31'),
(42, 1, 'Green breakfast smoothie', 'Blitz healthy ingredients for an energy-boosting breakfast. Using unsweetened brown rice milk fortified with calcium and vitamins makes it more nutritious', '229926215_38.jpg', 'veg', 1, '2020-09-07 01:56:49'),
(43, 1, 'Strawberry smoothie', 'Get your fruit fix with our strawberry smoothie made with banana and orange juice. It\'s free from dairy, so it\'s vegan too â€“ making it a great start to anyone\'s day', '453857421_39.jpg', 'veg', 1, '2020-09-07 01:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `dish_cart`
--

CREATE TABLE `dish_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dish_details_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dish_details`
--

CREATE TABLE `dish_details` (
  `id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `attribute` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish_details`
--

INSERT INTO `dish_details` (`id`, `dish_id`, `attribute`, `price`, `status`, `added_on`) VALUES
(7, 5, '1000 ml', 75, 1, '2020-08-17 10:02:59'),
(9, 5, '500 ml', 40, 1, '2020-08-18 10:16:38'),
(10, 5, '250 ml', 22, 1, '2020-08-19 11:09:25'),
(11, 6, 'Full', 280, 1, '2020-08-31 05:49:12'),
(12, 6, 'Half', 150, 1, '2020-08-31 05:49:12'),
(13, 6, 'Quarter', 80, 1, '2020-08-31 05:49:12'),
(15, 7, '4 pcs Packet', 50, 1, '2020-09-07 10:59:52'),
(16, 7, '2 pcs Packet', 30, 1, '2020-09-07 10:59:52'),
(17, 7, '1 pcs Packet', 20, 1, '2020-09-07 10:59:52'),
(18, 8, 'Full', 190, 1, '2020-09-07 11:10:52'),
(19, 8, 'Half', 100, 1, '2020-09-07 11:10:52'),
(20, 8, 'Quarter', 60, 1, '2020-09-07 11:10:52'),
(21, 9, 'Full à¦¹à¦¾à¦¡à¦¼à¦¿', 300, 1, '2020-09-07 11:19:12'),
(22, 9, 'Half à¦¹à¦¾à¦¡à¦¼à¦¿', 160, 1, '2020-09-07 11:19:12'),
(23, 9, 'Quarter à¦¹à¦¾à¦¡à¦¼à¦¿', 90, 1, '2020-09-07 11:19:12'),
(24, 10, 'Full à¦¹à¦¾à¦¡à¦¼à¦¿', 350, 1, '2020-09-07 11:24:31'),
(25, 10, 'Half à¦¹à¦¾à¦¡à¦¼à¦¿', 180, 1, '2020-09-07 11:24:31'),
(26, 10, 'Quarter à¦¹à¦¾à¦¡à¦¼à¦¿', 100, 1, '2020-09-07 11:24:31'),
(27, 11, '1 kg', 420, 1, '2020-09-07 12:17:31'),
(28, 11, '500 gm', 220, 1, '2020-09-07 12:17:31'),
(29, 11, '250 gm', 120, 1, '2020-09-07 12:17:31'),
(30, 12, '1 litre', 150, 1, '2020-09-07 12:26:42'),
(31, 12, '500 ml', 80, 1, '2020-09-07 12:26:42'),
(32, 12, '250 ml', 45, 1, '2020-09-07 12:26:42'),
(33, 13, '1 litre', 280, 1, '2020-09-07 12:30:02'),
(34, 13, '500 ml', 150, 1, '2020-09-07 12:30:02'),
(35, 13, '250 ml', 80, 1, '2020-09-07 12:30:02'),
(36, 14, '1 kg', 480, 1, '2020-09-07 12:35:09'),
(37, 14, '500 gm', 250, 1, '2020-09-07 12:35:09'),
(38, 14, '250 gm', 130, 1, '2020-09-07 12:35:09'),
(39, 15, 'Full', 150, 1, '2020-09-07 12:42:03'),
(40, 15, 'Half', 80, 1, '2020-09-07 12:42:03'),
(41, 16, 'Full', 320, 1, '2020-09-07 12:51:17'),
(42, 16, 'Half', 170, 1, '2020-09-07 12:51:17'),
(43, 17, 'Full', 280, 1, '2020-09-07 12:53:37'),
(44, 17, 'Half', 150, 1, '2020-09-07 12:53:37'),
(45, 17, 'Quarter', 80, 1, '2020-09-07 12:53:37'),
(46, 18, 'Full - 3pcs', 240, 1, '2020-09-07 12:56:57'),
(47, 18, 'Half - 2pcs', 160, 1, '2020-09-07 12:56:57'),
(48, 18, 'Quarter - 1pcs', 80, 1, '2020-09-07 12:56:57'),
(49, 19, 'Full', 280, 1, '2020-09-07 01:00:36'),
(50, 19, 'Half', 150, 1, '2020-09-07 01:00:36'),
(51, 19, 'Quarter', 80, 1, '2020-09-07 01:00:36'),
(52, 20, 'Full', 320, 1, '2020-09-07 01:02:28'),
(53, 20, 'Half', 160, 1, '2020-09-07 01:02:28'),
(54, 20, 'Quarter', 80, 1, '2020-09-07 01:02:28'),
(55, 21, 'Full', 350, 1, '2020-09-07 01:05:28'),
(56, 21, 'Half', 180, 1, '2020-09-07 01:05:28'),
(57, 21, 'Quarter', 95, 1, '2020-09-07 01:05:28'),
(58, 22, '1000 gm', 1200, 1, '2020-09-07 01:08:10'),
(59, 22, '500 gm', 650, 1, '2020-09-07 01:08:10'),
(60, 22, '250 gm', 350, 1, '2020-09-07 01:08:10'),
(61, 23, 'Full - 8pcs', 400, 1, '2020-09-07 01:13:24'),
(62, 23, 'Half - 4pcs', 200, 1, '2020-09-07 01:13:24'),
(63, 23, 'Quarter - 2pcs', 100, 1, '2020-09-07 01:13:24'),
(64, 24, 'Full', 350, 1, '2020-09-07 01:15:01'),
(65, 24, 'Half', 180, 1, '2020-09-07 01:15:01'),
(66, 25, 'Full', 250, 1, '2020-09-07 01:16:44'),
(67, 25, 'Half', 130, 1, '2020-09-07 01:16:44'),
(68, 25, 'Quarter', 70, 1, '2020-09-07 01:16:44'),
(69, 26, 'Full', 380, 1, '2020-09-07 01:18:31'),
(70, 26, 'Half', 200, 1, '2020-09-07 01:18:31'),
(71, 26, 'Quarter', 100, 1, '2020-09-07 01:18:31'),
(72, 27, 'Full - 4pcs', 320, 1, '2020-09-07 01:20:56'),
(73, 27, 'Half -2pcs', 165, 1, '2020-09-07 01:20:56'),
(74, 27, 'Quarter - 1pcs', 85, 1, '2020-09-07 01:20:56'),
(75, 28, 'Full - 500gm', 350, 1, '2020-09-07 01:23:29'),
(76, 28, 'Half - 250gm', 180, 1, '2020-09-07 01:23:29'),
(77, 29, 'Full', 220, 1, '2020-09-07 01:26:01'),
(78, 29, 'Half', 120, 1, '2020-09-07 01:26:01'),
(79, 29, 'Quarter', 60, 1, '2020-09-07 01:26:01'),
(80, 30, 'Full', 300, 1, '2020-09-07 01:27:26'),
(81, 30, 'Half', 160, 1, '2020-09-07 01:27:26'),
(82, 30, 'Quarter', 80, 1, '2020-09-07 01:27:26'),
(83, 31, 'Full', 250, 1, '2020-09-07 01:29:13'),
(84, 31, 'Half', 130, 1, '2020-09-07 01:29:13'),
(85, 32, 'Full', 280, 1, '2020-09-07 01:31:10'),
(86, 32, 'Half', 150, 1, '2020-09-07 01:31:10'),
(87, 32, 'Quarter', 75, 1, '2020-09-07 01:31:10'),
(88, 33, 'Full ', 320, 1, '2020-09-07 01:33:26'),
(89, 33, 'Half', 160, 1, '2020-09-07 01:33:26'),
(90, 33, 'Quarter', 80, 1, '2020-09-07 01:33:26'),
(91, 34, 'Full', 380, 1, '2020-09-07 01:39:09'),
(92, 34, 'Half', 190, 1, '2020-09-07 01:39:09'),
(93, 34, 'Quarter', 100, 1, '2020-09-07 01:39:09'),
(94, 35, 'Full', 280, 1, '2020-09-07 01:40:30'),
(95, 35, 'Half', 150, 1, '2020-09-07 01:40:30'),
(96, 36, 'Full', 280, 1, '2020-09-07 01:41:54'),
(97, 36, 'Half', 150, 1, '2020-09-07 01:41:54'),
(98, 37, 'Full', 420, 1, '2020-09-07 01:43:59'),
(99, 37, 'Half', 220, 1, '2020-09-07 01:43:59'),
(100, 37, 'Quarter', 110, 1, '2020-09-07 01:43:59'),
(101, 38, 'Full', 280, 1, '2020-09-07 01:49:45'),
(102, 39, 'Full', 220, 1, '2020-09-07 01:51:15'),
(103, 40, 'Full - 500ml', 320, 1, '2020-09-07 01:53:49'),
(104, 40, 'Half -250ml', 160, 1, '2020-09-07 01:53:49'),
(105, 41, 'Full - glass', 250, 1, '2020-09-07 01:55:31'),
(106, 41, 'Half - glass', 130, 1, '2020-09-07 01:55:31'),
(107, 42, 'Full - glass', 280, 1, '2020-09-07 01:56:49'),
(108, 42, 'Half - glass', 140, 1, '2020-09-07 01:56:49'),
(109, 43, 'Full - glass', 270, 1, '2020-09-07 01:58:42'),
(110, 43, 'Half - glass', 140, 1, '2020-09-07 01:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_details_id` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `dish_details_id`, `unit_price`, `qty`) VALUES
(1, 1, 13, 80, 5),
(2, 2, 12, 150, 1),
(3, 3, 9, 40, 5),
(4, 4, 12, 150, 10),
(5, 4, 11, 280, 5),
(6, 5, 10, 22, 10),
(7, 5, 12, 150, 5),
(8, 5, 7, 75, 5),
(9, 5, 11, 280, 2),
(10, 6, 12, 150, 2),
(11, 6, 9, 40, 3),
(12, 7, 11, 280, 6),
(13, 7, 12, 150, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `total_price` float NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL,
  `order_status` int(11) NOT NULL,
  `cancel_by` enum('User','Admin') DEFAULT NULL,
  `cancel_time` datetime DEFAULT NULL,
  `txnid` varchar(50) NOT NULL,
  `pay_id` varchar(50) NOT NULL,
  `online_payment_status` varchar(20) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `coupon_value` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL,
  `delivery_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`id`, `user_id`, `name`, `email`, `mobile`, `address`, `zip_code`, `total_price`, `payment_type`, `delivery_boy_id`, `payment_status`, `order_status`, `cancel_by`, `cancel_time`, `txnid`, `pay_id`, `online_payment_status`, `payment_method`, `coupon_id`, `coupon_code`, `coupon_value`, `added_on`, `delivery_date`) VALUES
(1, 5, 'Md. Ovi', 'iamovi104@gmail.com', '01712321254', 'Bangla Bazar,Dhaka', '1100', 450, 'wallet', 1, 'success', 4, NULL, NULL, '', '', 'No', 'Wallet Balance', 0, '', '', '2020-08-31 09:14:08', NULL),
(2, 5, 'Md. Ovi', 'iamovi104@gmail.com', '01712321254', 'Bangla Bazar', '1100', 200, 'wallet', NULL, 'success', 5, 'Admin', '2020-09-06 06:43:06', '', '', 'No', 'Wallet Balance', 0, '', '', '2020-01-22 09:24:18', NULL),
(3, 5, 'Md. Ovi', 'iamovi104@gmail.com', '01712321254', 'Bangla Bazar', '1100', 250, 'wallet', 2, 'success', 4, NULL, NULL, '', '', 'No', 'Wallet Balance', 0, '', '', '2020-09-05 09:42:06', NULL),
(4, 5, 'Md. Ovi', 'iamovi104@gmail.com', '01712321254', 'Bangla Bazar', '1100', 2700, 'online', 1, 'success', 4, NULL, NULL, 'SSLCZ_TEST_5f53096ee8b29', '20090594431ZHkIRbYKX8KXhrh', 'VALID', 'DBBLMOBILEB-Dbbl Mobile Banking', 2, 'First250', '250', '2020-08-18 09:43:42', '2020-09-05 02:43:38'),
(5, 1, 'Najmul Ovi', 'najmulovi999@gmail.com', '01812345678', '394/5,Gawair Bazar,Dakshinkhan', '1230', 1705, 'online', 1, 'success', 5, 'User', '2020-09-06 06:33:16', 'SSLCZ_TEST_5f53294a92a98', '20090512002719yqGgQKk8Sn32h', 'VALID', 'BKASH-BKash', 2, 'First250', '250', '2020-09-05 11:59:38', NULL),
(6, 1, 'Najmul Ovi', 'najmulovi999@gmail.com', '01812345678', '394/5,Gawair Bazar,Dakshinkhan', '1230', 470, 'wallet', 2, 'success', 4, NULL, NULL, '', '', 'No', 'Wallet Balance', 0, '', '', '2020-09-05 12:01:43', NULL),
(7, 7, 'Kazi Imam', 'neberhossain@gmail.com', '01912345655', 'Gunabati', '3536', 1780, 'online', NULL, 'success', 4, NULL, NULL, 'SSLCZ_TEST_5f558e2b52c32', '2009077352611V0zLGFyWCmDQO', 'VALID', 'BKASH-BKash', 2, 'First250', '250', '2020-09-07 07:34:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Cooking'),
(3, 'On the Way'),
(4, 'Delivered'),
(5, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_details_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `cart_min_price` int(11) NOT NULL,
  `cart_min_price_msg` varchar(255) NOT NULL,
  `website_close` int(11) NOT NULL,
  `wallet_amount` int(11) NOT NULL,
  `website_close_msg` varchar(255) NOT NULL,
  `wallet_balance_msg` varchar(255) NOT NULL,
  `referral_bonus_amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `cart_min_price`, `cart_min_price_msg`, `website_close`, `wallet_amount`, `website_close_msg`, `wallet_balance_msg`, `referral_bonus_amount`) VALUES
(1, 100, 'Cart minimum price should be Tk.100 or greater than Tk.100', 0, 50, 'Website closed for today', 'Your Wallet Balance is low than total cart amount.Please recharge your wallet balance for place order.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `email_verify` int(11) NOT NULL,
  `rand_str` varchar(20) NOT NULL,
  `referral_code` varchar(20) NOT NULL,
  `from_referral_code` varchar(20) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `status`, `email_verify`, `rand_str`, `referral_code`, `from_referral_code`, `added_on`) VALUES
(1, 'Najmul Ovi', 'najmulovi999@gmail.com', '01812345678', '$2y$10$7/bAFU2DyW3/w.MpW8xmv.iHPs2HEYwW8d66lHGzdkMXO7qOazN66', 1, 1, 'vvkzzwxjhyqdefr', '', '', '2020-08-20 05:45:39'),
(5, 'Md. Ovi', 'iamovi104@gmail.com', '01712321254', '$2y$10$n.F13MgxpuST4ujD5Omo3.hfU6rxCUvSZ1/vcCLZRm/2Ho/UJl6JG', 1, 1, 'smvzcdpxkjqrpgn', 'ehdsaqwcxzskhfj', '', '2020-09-04 09:44:49'),
(7, 'Kazi Imam', 'neberhossain@gmail.com', '01912345655', '$2y$10$sAZJEgOx8paX8rrRYkHJZ.DDYyooVdQHS2IdthjIs/SyJcu/Tn176', 1, 1, 'elsfxgjogfzulsr', 'msghzfamyrreepj', 'ehdsaqwcxzskhfj', '2020-09-07 07:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `user_id`, `amount`, `msg`, `type`, `added_on`) VALUES
(1, 5, 50, 'Registration Bonus', 'in', '2020-09-04 09:44:49'),
(2, 5, 170, 'Credit Added', 'in', '2020-09-04 11:59:24'),
(3, 5, 40, 'Shopping', 'out', '2020-09-05 12:00:16'),
(4, 5, 50, 'Credit Added', 'in', '2020-09-05 06:44:41'),
(6, 5, 300, 'Credit Added', 'in', '2020-09-05 08:58:53'),
(7, 5, 450, 'Shopping', 'out', '2020-09-05 09:14:08'),
(8, 5, 200, 'Credit Added', 'in', '2020-09-05 09:23:52'),
(9, 5, 200, 'Shopping', 'out', '2020-09-05 09:24:18'),
(10, 5, 300, 'Credit Added', 'in', '2020-09-05 09:40:53'),
(11, 5, 250, 'Shopping', 'out', '2020-09-05 09:42:06'),
(12, 1, 500, 'Credit Added', 'in', '2020-09-05 12:00:40'),
(13, 1, 470, 'Shopping', 'out', '2020-09-05 12:01:43'),
(14, 5, 50, 'Bonus From Admin', 'in', '2020-09-06 07:33:59'),
(15, 6, 50, 'Registration Bonus', 'in', '2020-09-06 10:56:01'),
(23, 5, 5, 'Referral Bonus From neberhossain@gmail.com', 'in', '2020-09-07 07:37:24'),
(22, 7, 50, 'Registration Bonus', 'in', '2020-09-07 07:30:45'),
(21, 6, 500, 'Credit Added', 'in', '2020-09-06 11:10:33'),
(20, 5, 5, 'Referral Bonus From neberhossain@gmail.com', 'in', '2020-09-06 11:07:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_master`
--
ALTER TABLE `coupon_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish_cart`
--
ALTER TABLE `dish_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish_details`
--
ALTER TABLE `dish_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `coupon_master`
--
ALTER TABLE `coupon_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `dish_cart`
--
ALTER TABLE `dish_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `dish_details`
--
ALTER TABLE `dish_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
