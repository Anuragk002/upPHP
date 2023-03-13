-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2023 at 07:44 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerceweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

CREATE TABLE `tbl_color` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

CREATE TABLE `tbl_country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_country`
--

INSERT INTO `tbl_country` (`country_id`, `country_name`) VALUES
(249, 'Mexico'),
(247, 'Canada'),
(250, 'United Kingdom'),
(251, 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cust_id` int(11) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_gender` varchar(50) NOT NULL,
  `cust_cname` varchar(100) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_phone` varchar(50) NOT NULL,
  `cust_country` int(11) NOT NULL,
  `cust_address` text NOT NULL,
  `cust_city` varchar(100) NOT NULL,
  `cust_state` varchar(100) NOT NULL,
  `cust_zip` varchar(30) NOT NULL,
  `cust_b_name` varchar(100) NOT NULL,
  `cust_b_cname` varchar(100) NOT NULL,
  `cust_b_phone` varchar(50) NOT NULL,
  `cust_b_country` int(11) NOT NULL,
  `cust_b_address` text NOT NULL,
  `cust_b_city` varchar(100) NOT NULL,
  `cust_b_state` varchar(100) NOT NULL,
  `cust_b_zip` varchar(30) NOT NULL,
  `cust_s_name` varchar(100) NOT NULL,
  `cust_s_gender` varchar(50) NOT NULL,
  `cust_s_cname` varchar(100) NOT NULL,
  `cust_s_phone` varchar(50) NOT NULL,
  `cust_s_email` varchar(250) NOT NULL,
  `cust_s_country` int(11) NOT NULL,
  `cust_s_address` text NOT NULL,
  `cust_s_city` varchar(100) NOT NULL,
  `cust_s_state` varchar(100) NOT NULL,
  `cust_s_zip` varchar(30) NOT NULL,
  `cust_password` varchar(100) NOT NULL,
  `cust_token` varchar(255) NOT NULL,
  `cust_datetime` varchar(100) NOT NULL,
  `cust_timestamp` varchar(100) NOT NULL,
  `cust_status` int(1) NOT NULL,
  `cust_guest` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_message`
--

CREATE TABLE `tbl_customer_message` (
  `customer_message_id` int(11) NOT NULL,
  `to_email` varchar(250) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `status_details` text NOT NULL,
  `order_details` text NOT NULL,
  `shipping_address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer_message`
--

INSERT INTO `tbl_customer_message` (`customer_message_id`, `to_email`, `subject`, `message`, `payment_id`, `status_details`, `order_details`, `shipping_address`) VALUES
(28, 'pankaj143giri@gmail.com', 'manual msg', 'hello', '1678711679', '<ul style=\"list-style-type:None;color:black\">\r\n			<li><b>Order ID: </b>1678711679</li>\r\n            <li><b>Order Date: </b>2023-03-13 05:47:59</li>\r\n            <li><b>Total Amount: </b>$356</li>\r\n            <li><b>Payment Status: </b>Pending</li></ul>', '\r\n            <table border=1 >\r\n            <tr>\r\n            <th>#</th>\r\n            <th>Product Name</th>\r\n            <th>Package</th>\r\n            <th>Price</th>\r\n            <th>Quanity</th>\r\n            <th>Total</th>\r\n            </tr>\r\n            \r\n                <tr>\r\n                <td>1</td>\r\n                <td>Citra 100mg</td>\r\n                <td>180 PILLS</td>\r\n                <td>$356</td>\r\n                <td>1</td>\r\n                <td>$356</td>\r\n                </tr>\r\n                \r\n            <tr>\r\n            <td colspan=5><b>Grand Total</b></td>\r\n            <td><b>$356</b></td>\r\n            </tr>\r\n            </table>\r\n            ', '\r\n            <u><b>Shipping Address-</b></u>\r\n            <ul style=\"padding-left:20px;list-style-type:None;color:black\">\r\n            <li><b>Name: </b>pankaj</li>\r\n            <li><b>Phone: </b>10234</li>\r\n            <li><b>Address: </b>lanbhua, sln, up, Canada, 1245</li>\r\n            </ul>'),
(29, 'pankaj143giri@gmail.com', 'manual msg', 'kj', '1678715682', '<ul style=\"list-style-type:None;color:black\">\r\n			<li><b>Order ID: </b>1678715682</li>\r\n            <li><b>Order Date: </b>2023-03-13 06:54:42</li>\r\n            <li><b>Total Amount: </b>$329</li>\r\n            <li><b>Payment Status: </b>Pending</li></ul>', '\r\n            <table border=1 >\r\n            <tr>\r\n            <th>#</th>\r\n            <th>Product Name</th>\r\n            <th>Package</th>\r\n            <th>Price</th>\r\n            <th>Quanity</th>\r\n            <th>Total</th>\r\n            </tr>\r\n            \r\n                <tr>\r\n                <td>1</td>\r\n                <td>Rivotril 2mg</td>\r\n                <td>90 PILLS</td>\r\n                <td>$329</td>\r\n                <td>1</td>\r\n                <td>$329</td>\r\n                </tr>\r\n                \r\n            <tr>\r\n            <td colspan=5><b>Grand Total</b></td>\r\n            <td><b>$329</b></td>\r\n            </tr>\r\n            </table>\r\n            ', '\r\n            <u><b>Shipping Address-</b></u>\r\n            <ul style=\"padding-left:20px;list-style-type:None;color:black\">\r\n            <li><b>Name: </b>pankaj</li>\r\n            <li><b>Phone: </b>10234</li>\r\n            <li><b>Address: </b>lanbhua, sln, up, Canada, 1245</li>\r\n            </ul>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_end_category`
--

CREATE TABLE `tbl_end_category` (
  `ecat_id` int(11) NOT NULL,
  `ecat_name` varchar(255) NOT NULL,
  `mcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `faq_id` int(11) NOT NULL,
  `faq_title` varchar(255) NOT NULL,
  `faq_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`faq_id`, `faq_title`, `faq_content`) VALUES
(1, 'How to find an item?', '<h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><font color=\"#222222\" face=\"opensans, Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif\"><span style=\"font-size: 15.7143px;\">We have a wide range of fabulous products to choose from.</span></font></h3><h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><span style=\"font-size: 15.7143px; color: rgb(34, 34, 34); font-family: opensans, \"Helvetica Neue\", Helvetica, Helvetica, Arial, sans-serif;\">Tip 1: If you\'re looking for a specific product, use the keyword search box located at the top of the site. Simply type what you are looking for, and prepare to be amazed!</span></h3><h3 class=\"checkout-complete-box font-bold txt16\" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; margin: 0.2rem 0px 0.5rem; padding: 0px; line-height: 1.4; background-color: rgb(250, 250, 250);\"><font color=\"#222222\" face=\"opensans, Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif\"><span style=\"font-size: 15.7143px;\">Tip 2: If you want to explore a category of products, use the Shop Categories in the upper menu, and navigate through your favorite categories where we\'ll feature the best products in each.</span></font><br><br></h3>\r\n'),
(2, 'What is your return policy?', '<p><span style=\"color: rgb(10, 10, 10); font-family: opensans, &quot;Helvetica Neue&quot;, Helvetica, Helvetica, Arial, sans-serif; font-size: 14px; text-align: center;\">You have 15 days to make a refund request after your order has been delivered.</span><br></p>\r\n'),
(3, ' I received a defective/damaged item, can I get a refund?', '<p>In case the item you received is damaged or defective, you could return an item in the same condition as you received it with the original box and/or packaging intact. Once we receive the returned item, we will inspect it and if the item is found to be defective or damaged, we will process the refund along with any shipping fees incurred.<br></p>\r\n'),
(4, 'When are ï¿½Returnsï¿½ not possible?', '<p class=\"a  \" style=\"box-sizing: inherit; text-rendering: optimizeLegibility; line-height: 1.6; margin-bottom: 0.714286rem; padding: 0px; font-size: 14px; color: rgb(10, 10, 10); font-family: opensans, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(250,=\"\" 250,=\"\" 250);\"=\"\">There are a few certain scenarios where it is difficult for us to support returns:</p><ol style=\"box-sizing: inherit; line-height: 1.6; margin-right: 0px; margin-bottom: 0px; margin-left: 1.25rem; padding: 0px; list-style-position: outside; color: rgb(10, 10, 10); font-family: opensans, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(250,=\"\" 250,=\"\" 250);\"=\"\"><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Return request is made outside the specified time frame, of 15 days from delivery.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Product is used, damaged, or is not in the same condition as you received it.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Defective products, which are covered under the manufacturer\'s warranty.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Any consumable item which has been used or installed.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Products with tampered or missing serial numbers.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Anything missing from the package you\'ve received including price tags, labels, original packing, freebies and accessories.</li><li style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-size: inherit;\">Fragile items, hygiene-related items.</li></ol>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `lang_id` int(11) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  `lang_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`lang_id`, `lang_name`, `lang_value`) VALUES
(1, 'Currency', '$'),
(2, 'Search Product', 'Search Product'),
(3, 'Search', 'Search'),
(4, 'Submit', 'Submit'),
(5, 'Update', 'Update'),
(6, 'Read More', 'Read More'),
(7, 'Serial', 'Serial'),
(8, 'Photo', 'Photo'),
(9, 'Login', 'Login'),
(10, 'Customer Login', 'Customer Login'),
(11, 'Click here to login', 'Click here to login'),
(12, 'Back to Login Page', 'Back to Login Page'),
(13, 'Logged in as', 'Logged in as'),
(14, 'Logout', 'Logout'),
(15, 'Register', 'Register'),
(16, 'Customer Registration', 'Customer Registration'),
(17, 'Registration Successful', 'Registration Successful'),
(18, 'Cart', 'Cart'),
(19, 'View Cart', 'View Cart'),
(20, 'Update Cart', 'Update Cart'),
(21, 'Back to Cart', 'Back to Cart'),
(22, 'Checkout', 'Checkout'),
(23, 'Proceed to Checkout', 'Proceed to Checkout'),
(24, 'Orders', 'Orders'),
(25, 'Order History', 'Order History'),
(26, 'Order Details', 'Order Details'),
(27, 'Payment Date and Time', 'Payment Date and Time'),
(28, 'Transaction ID', 'Transaction ID'),
(29, 'Paid Amount', 'Paid Amount'),
(30, 'Payment Status', 'Payment Status'),
(31, 'Payment Method', 'Payment Method'),
(32, 'Payment ID', 'Payment ID'),
(33, 'Payment Section', 'Payment Section'),
(34, 'Select Payment Method', 'Select Payment Method'),
(35, 'Select a Method', 'Select a Method'),
(36, 'PayPal', 'PayPal'),
(37, 'Stripe', 'Stripe'),
(38, 'Bank Deposit', 'Bank Deposit'),
(39, 'Card Number', 'Card Number'),
(40, 'CVV', 'CVV'),
(41, 'Month', 'Month'),
(42, 'Year', 'Year'),
(43, 'Send to this Details', 'Send to this Details'),
(44, 'Transaction Information', 'Transaction Information'),
(45, 'Include transaction id and other information correctly', 'Include transaction id and other information correctly'),
(46, 'Pay Now', 'Pay Now'),
(47, 'Product Name', 'Product Name'),
(48, 'Product Details', 'Product Details'),
(49, 'Categories', 'Categories'),
(50, 'Category:', 'Category:'),
(51, 'All Products Under', 'All Products Under'),
(52, 'Select Size', 'Select Size'),
(53, 'Select Color', 'Select Color'),
(54, 'Product Price', 'Product Price'),
(55, 'Quantity', 'Quantity'),
(56, 'Out of Stock', 'Out of Stock'),
(57, 'Share This', 'Share This'),
(58, 'Share This Product', 'Share This Product'),
(59, 'Product Description', 'Product Description'),
(60, 'Features', 'Features'),
(61, 'Conditions', 'Conditions'),
(62, 'Return Policy', 'Return Policy'),
(63, 'Reviews', 'Reviews'),
(64, 'Review', 'Review'),
(65, 'Give a Review', 'Give a Review'),
(66, 'Write your comment (Optional)', 'Write your comment (Optional)'),
(67, 'Submit Review', 'Submit Review'),
(68, 'You already have given a rating!', 'You already have given a rating!'),
(69, 'You must have to login to give a review', 'You must have to login to give a review'),
(70, 'No description found', 'No description found'),
(71, 'No feature found', 'No feature found'),
(72, 'No condition found', 'No condition found'),
(73, 'No return policy found', 'No return policy found'),
(74, 'Review not found', 'Review not found'),
(75, 'Customer Name', 'Customer Name'),
(76, 'Comment', 'Comment'),
(77, 'Comments', 'Comments'),
(78, 'Rating', 'Rating'),
(79, 'Previous', 'Previous'),
(80, 'Next', 'Next'),
(81, 'Sub Total', 'Sub Total'),
(82, 'Total', 'Total'),
(83, 'Action', 'Action'),
(84, 'Shipping Cost', 'Shipping Cost'),
(85, 'Continue Shopping', 'Continue Shopping'),
(86, 'Update Billing Address', 'Update Billing Address'),
(87, 'Update Shipping Address', 'Update Shipping Address'),
(88, 'Update Billing and Shipping Info', 'Update Billing and Shipping Info'),
(89, 'Dashboard', 'Dashboard'),
(90, 'Welcome to the Dashboard', 'Welcome to the Dashboard'),
(91, 'Back to Dashboard', 'Back to Dashboard'),
(92, 'Subscribe', 'Subscribe'),
(93, 'Subscribe To Our Newsletter', 'Subscribe To Our Newsletter'),
(94, 'Email Address', 'Email Address'),
(95, 'Enter Your Email Address', 'Enter Your Email Address'),
(96, 'Password', 'Password'),
(97, 'Forget Password', 'Forget Password'),
(98, 'Retype Password', 'Retype Password'),
(99, 'Update Password', 'Update Password'),
(100, 'New Password', 'New Password'),
(101, 'Retype New Password', 'Retype New Password'),
(102, 'Full Name', 'Full Name'),
(103, 'Company Name', 'Company Name'),
(104, 'Phone Number', 'Phone Number'),
(105, 'Address', 'Address'),
(106, 'Country', 'Country'),
(107, 'City', 'City'),
(108, 'State', 'State'),
(109, 'Zip Code', 'Zip Code'),
(110, 'About Us', 'About Us'),
(111, 'Featured Posts', 'Featured Posts'),
(112, 'Popular Posts', 'Popular Posts'),
(113, 'Recent Posts', 'Recent Posts'),
(114, 'Contact Information', 'Contact Information'),
(115, 'Contact Form', 'Contact Form'),
(116, 'Our Office', 'Our Office'),
(117, 'Update Profile', 'Update Profile'),
(118, 'Send Message', 'Send Message'),
(119, 'Message', 'Message'),
(120, 'Find Us On Map', 'Find Us On Map'),
(121, 'Congratulation! Payment is successful.', 'Congratulation! Payment is successful.'),
(122, 'Billing and Shipping Information is updated successfully.', 'Billing and Shipping Information is updated successfully.'),
(123, 'Customer Name can not be empty.', 'Customer Name can not be empty.'),
(124, 'Phone Number can not be empty.', 'Phone Number can not be empty.'),
(125, 'Address can not be empty.', 'Address can not be empty.'),
(126, 'You must have to select a country.', 'You must have to select a country.'),
(127, 'City can not be empty.', 'City can not be empty.'),
(128, 'State can not be empty.', 'State can not be empty.'),
(129, 'Zip Code can not be empty.', 'Zip Code can not be empty.'),
(130, 'Profile Information is updated successfully.', 'Profile Information is updated successfully.'),
(131, 'Email Address can not be empty', 'Email Address can not be empty'),
(132, 'Email and/or Password can not be empty.', 'Email and/or Password can not be empty.'),
(133, 'Email Address does not match.', 'Email Address does not match.'),
(134, 'Email address must be valid.', 'Email address must be valid.'),
(135, 'You email address is not found in our system.', 'You email address is not found in our system.'),
(136, 'Please check your email and confirm your subscription.', 'Please check your email and confirm your subscription.'),
(137, 'Your email is verified successfully. You can now login to our website.', 'Your email is verified successfully. You can now login to our website.'),
(138, 'Password can not be empty.', 'Password can not be empty.'),
(139, 'Passwords do not match.', 'Passwords do not match.'),
(140, 'Please enter new and retype passwords.', 'Please enter new and retype passwords.'),
(141, 'Password is updated successfully.', 'Password is updated successfully.'),
(142, 'To reset your password, please click on the link below.', 'To reset your password, please click on the link below.'),
(143, 'Password Reset Request', 'Password Reset Request'),
(144, 'The password reset time (24 hours) has expired. Please again try to reset your password.', 'The password reset time (24 hours) has expired. Please again try to reset your password.'),
(145, 'A confirmation link is sent to your email address. You will get the password reset information in there.', 'A confirmation link is sent to your email address. You will get the password reset information in there.'),
(146, 'Password is reset successfully. You can login now.', 'Password is reset successfully. You can login now.'),
(147, 'Email Address Already Exists', 'Email Address Already Exists.'),
(148, 'Sorry! Your account is inactive. Please contact to the administrator.', 'Sorry! Your account is inactive. Please contact to the administrator.'),
(149, 'Change Password', 'Change Password'),
(150, 'Registration Email Confirmation for YOUR WEBSITE', 'Registration Email Confirmation for YOUR WEBSITE.'),
(151, 'Thank you for your registration! Your account has been created. To active your account click on the link below:', 'Thank you for your registration! Your account has been created. To activate your account, please click on the link below:'),
(152, 'Your registration is completed. Please check your email address to follow the process to confirm your registration.', 'Your registration is completed. Please check your email address to follow the process to confirm your registration.'),
(153, 'No Product Found', 'No Product Found'),
(154, 'Add to Cart', 'Add to Cart'),
(155, 'Related Products', 'Related Products'),
(156, 'See all related products from below', 'See all the related products from below'),
(157, 'Size', 'Size'),
(158, 'Color', 'Color'),
(159, 'Price', 'Price'),
(160, 'Please login as customer to checkout', 'Please login as customer to checkout'),
(161, 'Billing Address', 'Billing Address'),
(162, 'Shipping Address', 'Shipping Address'),
(163, 'Rating is Submitted Successfully!', 'Rating is Submitted Successfully!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mid_category`
--

CREATE TABLE `tbl_mid_category` (
  `mcat_id` int(11) NOT NULL,
  `mcat_name` varchar(255) NOT NULL,
  `tcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `pkg_name` varchar(100) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `pkg_price` varchar(50) NOT NULL,
  `payment_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `product_id`, `product_name`, `pkg_name`, `quantity`, `pkg_price`, `payment_id`) VALUES
(3, 10015, 'Valium (Diazepam)', '90 PILLS', '1', '310', '1677704742'),
(4, 10012, 'Xanax Alko 1mg', '90 PILLS', '1', '355', '1677961829'),
(5, 10017, 'Citra 100mg', '180 PILLS', '1', '356', '1678711679'),
(6, 10007, 'Rivotril 2mg', '90 PILLS', '1', '329', '1678715682'),
(7, 10019, 'Tapentadol 100mg', '180 PILLS', '1', '340', '1678723365'),
(8, 10008, 'Bensedin', '90 PILLS', '1', '370', '1678723474'),
(9, 10019, 'Tapentadol 100mg', '180 PILLS', '1', '340', '1678723697');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE `tbl_page` (
  `id` int(11) NOT NULL,
  `about_title` varchar(255) NOT NULL,
  `about_content` text NOT NULL,
  `about_banner` varchar(255) NOT NULL,
  `about_meta_title` varchar(255) NOT NULL,
  `about_meta_keyword` text NOT NULL,
  `about_meta_description` text NOT NULL,
  `faq_title` varchar(255) NOT NULL,
  `faq_banner` varchar(255) NOT NULL,
  `faq_meta_title` varchar(255) NOT NULL,
  `faq_meta_keyword` text NOT NULL,
  `faq_meta_description` text NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_banner` varchar(255) NOT NULL,
  `blog_meta_title` varchar(255) NOT NULL,
  `blog_meta_keyword` text NOT NULL,
  `blog_meta_description` text NOT NULL,
  `contact_title` varchar(255) NOT NULL,
  `contact_banner` varchar(255) NOT NULL,
  `contact_meta_title` varchar(255) NOT NULL,
  `contact_meta_keyword` text NOT NULL,
  `contact_meta_description` text NOT NULL,
  `pgallery_title` varchar(255) NOT NULL,
  `pgallery_banner` varchar(255) NOT NULL,
  `pgallery_meta_title` varchar(255) NOT NULL,
  `pgallery_meta_keyword` text NOT NULL,
  `pgallery_meta_description` text NOT NULL,
  `vgallery_title` varchar(255) NOT NULL,
  `vgallery_banner` varchar(255) NOT NULL,
  `vgallery_meta_title` varchar(255) NOT NULL,
  `vgallery_meta_keyword` text NOT NULL,
  `vgallery_meta_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `about_title`, `about_content`, `about_banner`, `about_meta_title`, `about_meta_keyword`, `about_meta_description`, `faq_title`, `faq_banner`, `faq_meta_title`, `faq_meta_keyword`, `faq_meta_description`, `blog_title`, `blog_banner`, `blog_meta_title`, `blog_meta_keyword`, `blog_meta_description`, `contact_title`, `contact_banner`, `contact_meta_title`, `contact_meta_keyword`, `contact_meta_description`, `pgallery_title`, `pgallery_banner`, `pgallery_meta_title`, `pgallery_meta_keyword`, `pgallery_meta_description`, `vgallery_title`, `vgallery_banner`, `vgallery_meta_title`, `vgallery_meta_keyword`, `vgallery_meta_description`) VALUES
(1, 'About Us', '<p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Welcome to Unit Pharma, your trusted provider of high-quality medical products and services. Our experienced and knowledgeable pharmacists and staff are committed to helping you manage your health and well-being.</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">At UnitPharma, we believe that access to reliable healthcare should be affordable and convenient. That\'s why we offer a wide range of prescription and over-the-counter medications, medical supplies, and equipment to meet the needs of our diverse customer base. We ensure what you see is exactly what you get!</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 23pt 0pt;\"><br></p><h1 dir=\"ltr\" style=\"line-height:1.5;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 23pt 0pt;\"><span id=\"docs-internal-guid-db3d4eca-7fff-2f40-573e-f6b677cc88ab\"><span style=\"font-size: 36pt; font-family: Poppins, sans-serif; color: rgb(40, 40, 40); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Our Goal at </span><span style=\"font-size: 36pt; font-family: Poppins, sans-serif; color: rgb(227, 61, 85); background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;\">Unit Pharma</span></span><br></h1><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 38pt 0pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Our online store is different and unique from other online pharmacies in many aspects not only in terms of availability. We offer all types of medicines which are not easily available in local pharmacies. Our website is one of the reputed stores in the online market in terms of performance and secured payment service. Considering the debilitating health conditions of individuals, we receive orders and dispatch them to the destined place within a stipulated period of time.</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 38pt 0pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">We ask your personal information when you are going to order the medicine from our online pharmacy. Our team helps its customer 24*7 and keeps personal information safe and secure. In comparison to other sites, the team of Unit Pharma provides you original medicines, not fake products as is seen in the case of other websites. These qualities of our medicines set us apart from others, establishing us to be the prominent online drug store. UnitPharma tries to satisfy its customers in every aspect and strives to stay ahead of other competitors, fulfilling the requirements of customers.</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:38pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Our team leaves no stone unturned to provide you with improved services through our website and relentlessly works day and night. We keep updating our website periodically with new information about medicines for your awareness. Our team puts in efforts to get your love, support, and your feedback which encourages us to keep working for the betterment each day. Our website team takes feedbacks seriously and works accordingly in making the website top searching online pharmacy in the entire USA. The benefits of buying medicines from our online pharmacy store are:</span></p><ol style=\"margin-top:0;margin-bottom:0;padding-inline-start:48px;\"><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:15pt;font-family:Arial;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;margin-top:0pt;margin-bottom:0pt;padding:7.5pt 0pt 0pt 0pt;\" role=\"presentation\"><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Reasonable Prices</span><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br></span><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">We provide you medicines at reasonable prices without compromising on their efficacy and quality. If compared, the prices of medicine at our online pharmacy are lesser than medicines available at other online pharmacies. You can also write us an email to get your order booked and delivered the medicine to your doorstep. We are always worried about the health of individuals and strive to get things done in whatever way we receive it from them. This is the rare and unique quality that sets us apart from others.</span><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br><br></span></p></li></ol><ol style=\"margin-top:0;margin-bottom:0;padding-inline-start:48px;\" start=\"2\"><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:15pt;font-family:Arial;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Satisfaction</span><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br></span><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">We go our way out for customer satisfaction and do everything possible with continued improvisation on our services. Not just in the quality of medicines but in every aspect, we try to reach perfection, providing customers with the best services 24*7. Our aim is to satisfy our customers through our medicines & services because we understand the value of life.</span><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br><br></span></p></li></ol><ol style=\"margin-top:0;margin-bottom:0;padding-inline-start:48px;\" start=\"3\"><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:15pt;font-family:Arial;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;margin-top:0pt;margin-bottom:69pt;\" role=\"presentation\"><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Trust and Quality</span><span style=\"font-size:15pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\"><br></span><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Your trust in us keeps us going with confidence. Things in the business of medicine are fragile and every step is taken to ensure things are done correctly. To retain the trust, we always provide the best quality medicines and try not to fiddle with the ingredients to keep the authenticity intact. Quality is always a top priority for us, so we offer our patients the best quality medicines from a certified pharmacy in the USA.</span></p></li></ol><h2 dir=\"ltr\" style=\"line-height:1.875;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 23pt 0pt;\"><span style=\"font-size:24pt;font-family:Poppins,sans-serif;color:#282828;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Our Mission</span></h2><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 23pt 0pt;\"><span style=\"font-size:11.5pt;font-family:Poppins,sans-serif;color:#555555;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Keeping aside business, all customers who show trust in us are satisfied with the best outcomes one can ever experience. We never consider customers as customers but the family who needs the utmost care amid the turbulence owing to bad health. Your health and wellness are all that give us daily motivation. We aim to provide you medicines that work efficiently, causing minimal side effects in rare cases. You can get our medicines delivered to your doorstep by ordering online from Unit Pharma at affordable prices. You can save precious time and get quick delivery along with the satisfaction that you will be enjoying great health for a long.</span></p><p dir=\"ltr\" style=\"line-height:1.38;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\"><span id=\"docs-internal-guid-ae1bd8ba-7fff-065d-d936-24752db41e25\"><br></span></p>', 'about-banner.jpg', 'About us - Unit Pharma', 'about unitpharma.com, about unit pharma, about unit pharma', 'Our goal has always been to get the best medical products.', 'FAQ', 'faq-banner.jpg', 'FAQ - Unit Pharma', 'faq unitpharma.com, faq unitpharma, faq unit pharma, help unitpharma, help unit pharma, unitpharma help section', 'We are available 24*7 to support our customers. We provide customers with the best services 24*7. Our aim is to satisfy our customers through our medicines & services because we understand the value of life.\r\n', 'Blog', 'blog-banner.jpg', 'Unit Pharma - Blog', '', '', 'Contact Us', 'contact-banner.jpg', 'Contact us - Unit Pharma', 'contact to unitpharma.com, contact unit pharma, contact unitpharma', 'To reach Unit Pharma\'s customer care please visit our contact page and start chatting with a customer service representative. You can write an email to us: support@unitpharma.com or call us at +1 (903) 429-5515.', 'Photo Gallery', 'pgallery-banner.jpg', 'Unit Pharma - Photo Gallery', '', '', 'Video Gallery', 'vgallery-banner.jpg', 'Unit Pharma - Video Gallery', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_date` varchar(50) NOT NULL,
  `order_date` varchar(100) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_cvv` varchar(10) NOT NULL,
  `card_month` varchar(10) NOT NULL,
  `card_year` varchar(10) NOT NULL,
  `bank_transaction_info` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `tracking_id` varchar(100) NOT NULL,
  `tracking_link` text NOT NULL,
  `tracking_date` varchar(100) NOT NULL,
  `shipping_status` varchar(20) NOT NULL,
  `shipping_date` varchar(100) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `s_name` varchar(250) NOT NULL,
  `s_phone` varchar(50) NOT NULL,
  `s_email` varchar(250) NOT NULL,
  `s_address` text NOT NULL,
  `s_city` varchar(250) NOT NULL,
  `s_state` varchar(250) NOT NULL,
  `s_country` int(11) NOT NULL,
  `s_zip` varchar(30) NOT NULL,
  `comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `customer_id`, `customer_name`, `customer_email`, `payment_date`, `order_date`, `txnid`, `paid_amount`, `card_number`, `card_cvv`, `card_month`, `card_year`, `bank_transaction_info`, `payment_method`, `payment_status`, `tracking_id`, `tracking_link`, `tracking_date`, `shipping_status`, `shipping_date`, `payment_id`, `s_name`, `s_phone`, `s_email`, `s_address`, `s_city`, `s_state`, `s_country`, `s_zip`, `comment`) VALUES
(10003, 0, 'GUEST', '', '', '2023-03-01 13:05:42', '', 310, '', '', '', '', '', 'Paypal/Western Union/Other', 'Pending', '-1', '', '', 'Pending', '', '1677704742', 'Arpit', '82829291919', '8585arpit@gmail.com', 'po box 621 pittsburg texas 75686', 'Texas ', 'texas', 251, '75686', ''),
(10004, 0, 'GUEST', '', '', '2023-03-04 12:30:29', '', 355, '', '', '', '', '', 'Paypal/Western Union/Other', 'Pending', '-1', '', '', 'Pending', '', '1677961829', 'David ', 'Joseph ', 'arpit809024@gmail.com', '735 milford mt pleasant Road milford new jersey 08846', 'milford', 'new jersey', 251, '08846', ''),
(10005, 0, 'GUEST', '', '2023-03-13 05:56:03', '2023-03-13 05:47:59', '', 356, '', '', '', '', '', 'Venmo', 'Completed', '12', '12', '2023-03-13 06:00:18', 'Completed', '2023-03-13 07:18:55', '1678711679', 'pankaj', '10234', 'pankaj143giri@gmail.com', 'lanbhua', 'sln', 'up', 247, '1245', ''),
(10006, 0, 'GUEST', '', '2023-03-13 06:57:28', '2023-03-13 06:54:42', '', 329, '', '', '', '', '', 'Zelle', 'Completed', 'l', 'll', '2023-03-13 07:01:09', 'Completed', '2023-03-13 07:03:37', '1678715682', 'pankaj', '10234', 'pankaj143giri@gmail.com', 'lanbhua', 'sln', 'up', 247, '1245', ''),
(10007, 0, 'GUEST', '', '', '2023-03-13 09:02:45', '', 340, '', '', '', '', '', 'Cash App', 'Pending', '-1', '', '', 'Pending', '', '1678723365', 'pankaj', '10234', 'pankaj143giri@gmail.com', 'lanbhua', 'sln', 'up', 247, '1245', 'secure hona chaiye'),
(10008, 0, 'GUEST', '', '', '2023-03-13 09:04:34', '', 370, '', '', '', '', '', 'Western Union', 'Pending', '-1', '', '', 'Pending', '', '1678723474', 'pankaj', '10234', 'pankaj143giri@gmail.com', 'lanbhua', 'sln', 'up', 247, '1245', ''),
(10009, 0, 'GUEST', '', '', '2023-03-13 09:08:17', '', 340, '', '', '', '', '', 'Other', 'Pending', '-1', '', '', 'Pending', '', '1678723697', 'pankaj', '10234', 'pankaj143giri@gmail.com', 'lanbhua', 'sln', 'up', 247, '1245', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo`
--

CREATE TABLE `tbl_photo` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `total_view` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_old_price` varchar(10) NOT NULL,
  `p_current_price` varchar(10) NOT NULL,
  `p_qty` int(10) NOT NULL,
  `p_featured_photo` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `p_short_description` text NOT NULL,
  `p_feature` text NOT NULL,
  `p_condition` text NOT NULL,
  `p_return_policy` text NOT NULL,
  `p_total_view` int(11) NOT NULL,
  `p_is_featured` int(1) NOT NULL,
  `p_is_active` int(1) NOT NULL,
  `tcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`p_id`, `p_name`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `tcat_id`) VALUES
(10002, 'Cialis 20mg', '', '', 100, 'product-featured-10002.jpg', '<p><br></p>', 'Cialis is a treatment for adult men with erectile dysfunction. This is when a man cannot get, or keep a hard, erect penis suitable for sexual activity. CIALIS has been shown to significantly improve the ability to obtain a hard erect penis suitable for sexual activity.\r\nIt is also used to treat urinary symptoms caused due to an enlargement of the prostate gland (a walnut-sized gland located just below the bladder that secretes fluid to nourish and transport the sperm) in older men. ', '', '', '', 51, 1, 1, 10004),
(10003, 'Viagra 100mg', '', '', 100, 'product-featured-10003.png', '', 'Viagra 100mg Tablet is a prescription medicine used to treat erectile dysfunction (impotence) in men. It works by increasing blood flow to the penis. This helps men to get or maintain an erection. It belongs to a group of medicines known as phosphodiesterase type 5 (PDE 5) inhibitors.', '', '', '', 38, 1, 1, 10004),
(10004, 'Belbien (Zolpidem) 10mg', '', '', 100, 'product-featured-10004.png', '', 'Zolpidem is used for a short time to treat a certain sleep problem (insomnia) in adults. If you have trouble falling asleep, it helps you fall asleep faster, so you can get a better night\'s rest. Zolpidem belongs to a class of drugs called sedative-hypnotics. It acts on your brain to produce a calming effect.', '', '', '', 21, 1, 1, 10003),
(10005, 'Zoltrate 10mg', '', '', 100, 'product-featured-10005.png', '', 'The name of your medicine is Zolpidem 5mg or 10mg Tablets (called zolpidem throughout this leaflet). Zolpidem contains a medicine called zolpidem tartrate. This belongs to a group of medicines called hypnotics. It works by acting on your brain to help you sleep.', '', '', '', 52, 1, 1, 10003),
(10006, 'Lypin 10mg', '', '', 100, 'product-featured-10006.png', '', 'Lypin 10mg Tablet is used for short-term treatment of insomnia. It reduces sleep onset time and frequent awakening at night. This medicine improves sleep maintenance and therefore ensures sound sleep.', '', '', '', 38, 1, 1, 10003),
(10007, 'Rivotril 2mg', '', '', 100, 'product-featured-10007.png', '', 'Rivotril 2mg Tablet belongs to a class of medicines called benzodiazepines and is used to treat anxiety, stop seizures (fits) or relax tense muscles. This can also help relieve difficulty sleeping (insomnia), and is usually prescribed for a short period of time, if used to treat sleeping problems.', '', '', '', 58, 1, 1, 10000),
(10008, 'Bensedin', '', '', 100, 'product-featured-10008.png', '', 'Bensedin (Diazepam) is indicated for the management of anxiety disorders or for the short-term relief of the symptoms of anxiety. Anxiety or tension associated with the stress of everyday life usually does not require treatment with an anxiolytic.\r\n\r\nIn acute alcohol withdrawal, diazepam may be useful in the symptomatic relief of acute agitation, tremor, impending or acute delirium tremens and hallucinosis.', '', '', '', 59, 1, 1, 10000),
(10009, 'Lorazepam', '', '', 100, 'product-featured-10009.jpg', '', 'Lorazepam is used to relieve anxiety. Lorazepam is also used to treat insomnia caused by anxiety or temporary situational stress. Lorazepam is in a class of medications called benzodiazepines. It works by slowing activity in the brain to allow for relaxation.', '', '', '', 72, 1, 1, 10000),
(10010, 'Clonazepam 2mg', '', '', 100, 'product-featured-10010.png', '', 'Clonazepam belongs to a class of medicines called benzodiazepines and is used to treat anxiety, stop seizures (fits) or relax tense muscles.', '', '', '', 47, 1, 1, 10000),
(10011, 'Ksalol 1mg', '', '', 100, 'product-featured-10011.png', '', 'Ksalol belongs to a class of medications known as benzodiazepines. It\'s prescribed to treat generalized anxiety disorder, panic disorder and insomnia.', '', '', '', 42, 1, 1, 10000),
(10012, 'Xanax Alko 1mg', '', '', 100, 'product-featured-10012.png', '', 'Alko 1 MG (Xanax) Tablets are brand name for the drug alprazolam; it belongs to a group of drugs called benzodiazepines. This formula issued to treat anxiety and panic disorders. It is used to treat anxiety. It alters brain activity, calms it, and provides relief from panic attacks by relaxing the nerves.', '', '', '', 62, 1, 1, 10000),
(10013, 'Alprazolam (Alpz-1) 1mg', '', '', 100, 'product-featured-10013.png', '', 'Alprazolam is used to relieve excess (moderate to severe) anxiety and to treat anxiety associated with depression.', '', '', '', 24, 1, 1, 10000),
(10014, 'Rlam 1mg', '', '', 100, 'product-featured-10014.png', '', 'It belongs to a group of drugs called benzodiazepines. This formula is used to treat anxiety and panic disorders.', '', '', '', 20, 1, 1, 10000),
(10015, 'Valium (Diazepam)', '', '', 100, 'product-featured-10015.png', '', 'Valium is a prescription medicine used to treat symptoms of anxiety, muscle spasm, alcohol withdrawal and as a sedative before surgery or to treat seizures. Valium may be used alone or with other medications.\r\nValium belongs to a class of drugs called Antianxiety Agents; Anxiolytics, Benzodiazepines; Skeletal Muscle Relaxants; Anticonvulsants, Benzodiazepine.', '', '', '', 71, 1, 1, 10000),
(10016, 'Multivitamin Supreme, Zinc, Calcium and Vitamin D Capsule for Immunity, Energy, Overall Health', '', '', 100, 'product-featured-10016.jpeg', '', '', '', '', '', 24, 1, 0, 10001),
(10017, 'Citra 100mg', '', '', 100, 'product-featured-10017.png', '', '<p><span style=\"font-family: robotoregular; font-size: 16px; text-align: justify;\">Citra is an analgesic that is used to provide relief from pain. It is used for treating moderate and severe pain. It is also effective in pain that is not curable by weak painkillers. Citra can also be given in pain after serious injury and operation. Buy Citra 100mg online and get free delivery.</span><br></p>', '', '', '', 7, 1, 1, 10001),
(10018, 'Soma 350mg (Carisoprodol)', '', '', 100, 'product-featured-10018.png', '', 'Carisoprodol (Soma) is a muscle relaxant that\'s used to treat muscle pain and discomfort. It\'s taken by mouth, typically 4 times daily. Carisoprodol (Soma) is a controlled substance medication and it\'s only approved for short-term treatment of muscle pain and should only be taken for up to 2 to 3 weeks.', '', '', '', 12, 1, 1, 10001),
(10019, 'Tapentadol 100mg', '', '', 100, 'product-featured-10019.png', '', 'Tapentadol tablets are used to treat moderate to severe acute pain (pain that begins suddenly, has a specific cause, and is expected to go away when the cause of the pain is healed). Tapentadol extended-release tablets are used to treat severe neuropathic pain (pain caused by nerve damage) in people who have diabetes. ', '', '', '', 10, 1, 1, 10001),
(10020, 'Oltram 100mg', '', '', 100, 'product-featured-10020.png', '', 'This medication is an opioid analgesic, prescribed for moderate to severe pain in adults. It works by changing the way the body senses pain.', '', '', '', 4, 1, 1, 10001);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_color`
--

CREATE TABLE `tbl_product_color` (
  `id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_package`
--

CREATE TABLE `tbl_product_package` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `pkg_name` varchar(255) NOT NULL,
  `pkg_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product_package`
--

INSERT INTO `tbl_product_package` (`id`, `p_id`, `pkg_name`, `pkg_price`) VALUES
(10040, 10003, '180 PILLS', 210),
(10041, 10003, '360 PILLS', 297),
(10042, 10004, '90 PILLS', 360),
(10043, 10004, '180 PILLS', 549),
(10046, 10006, '90 PILLS', 330),
(10047, 10006, '180 PILLS', 565),
(10060, 10009, '90 PILLS', 349),
(10061, 10009, '180 PILLS', 478),
(10066, 10010, '90 PILLS', 350),
(10067, 10010, '180 PILLS', 580),
(10072, 10013, '90 PILLS', 319),
(10073, 10013, '180 PILLS', 479),
(10074, 10014, '90 PILLS', 329),
(10075, 10014, '180 PILLS', 459),
(10080, 10015, '90 PILLS', 310),
(10081, 10015, '180 PILLS', 488),
(10083, 10012, '90 PILLS', 355),
(10084, 10012, '180 PILLS', 488),
(10087, 10016, '90 PILLS', 200),
(10098, 10011, '90 PILLS', 380),
(10099, 10011, '180 PILLS', 470),
(10102, 10008, '90 PILLS', 370),
(10103, 10008, '180 PILLS', 490),
(10106, 10007, '90 PILLS', 329),
(10107, 10007, '180 PILLS', 459),
(10126, 10002, '180 PILLS', 180),
(10127, 10002, '360 PILLS', 289),
(10128, 10005, '90 PILLS', 330),
(10129, 10005, '180 PILLS', 510),
(10130, 10017, '180 PILLS', 356),
(10131, 10017, '360 PILLS', 589),
(10136, 10018, '180 PILLS', 210),
(10137, 10018, '360 PILLS', 396),
(10140, 10019, '180 PILLS', 340),
(10141, 10019, '360 PILLS', 520),
(10144, 10020, '180 PILLS', 400),
(10145, 10020, '360 PILLS', 670);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_photo`
--

CREATE TABLE `tbl_product_photo` (
  `pp_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_photo`
--

INSERT INTO `tbl_product_photo` (`pp_id`, `photo`, `p_id`) VALUES
(10002, '10002.jpg', 10002),
(10003, '10003.jpg', 10002),
(10004, '10004.jpg', 10003),
(10010, '10010.jpg', 10009),
(10014, '10014.png', 10009),
(10015, '10015.jpeg', 10016),
(10016, '10016.jpeg', 10016),
(10017, '10017.jpg', 10011),
(10019, '10019.png', 10008),
(10021, '10021.png', 10007),
(10022, '10022.png', 10020);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_size`
--

CREATE TABLE `tbl_product_size` (
  `id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `rt_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`rt_id`, `p_id`, `cust_id`, `comment`, `rating`) VALUES
(10023, 10003, -2, '', 5),
(10024, 10004, -2, '', 5),
(10026, 10006, -2, '', 5),
(10033, 10009, -2, '', 5),
(10036, 10010, -2, '', 5),
(10039, 10013, -2, '', 5),
(10040, 10014, -2, '', 5),
(10043, 10015, -2, '', 5),
(10045, 10012, -2, '', 5),
(10048, 10016, -2, '', 5),
(10054, 10011, -2, '', 5),
(10056, 10008, -2, '', 5),
(10058, 10007, -2, '', 5),
(10068, 10002, -2, '', 5),
(10069, 10005, -2, '', 5),
(10070, 10017, -2, '', 5),
(10073, 10018, -2, '', 5),
(10075, 10019, -2, '', 5),
(10077, 10020, -2, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE `tbl_service` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`id`, `title`, `content`, `photo`) VALUES
(5, 'Easy Returns', 'Return any item before 15 days!', 'service-5.png'),
(6, 'Free Shipping', 'Enjoy free shipping inside US.', 'service-6.png'),
(7, 'Fast Shipping', 'Items are shipped within 24 hours.', 'service-7.png'),
(8, 'Satisfaction Guarantee', 'We guarantee you with our quality satisfaction.', 'service-8.png'),
(9, 'Secure Checkout', 'Providing Secure Checkout Options for all', 'service-9.png'),
(10, 'Money Back Guarantee', 'Offer money back guarantee on our products', 'service-10.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `footer_about` text NOT NULL,
  `footer_copyright` text NOT NULL,
  `contact_address` text NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `contact_fax` varchar(255) NOT NULL,
  `contact_map_iframe` text NOT NULL,
  `receive_email` varchar(255) NOT NULL,
  `receive_email_subject` varchar(255) NOT NULL,
  `receive_email_thank_you_message` text NOT NULL,
  `forget_password_message` text NOT NULL,
  `total_recent_post_footer` int(10) NOT NULL,
  `total_popular_post_footer` int(10) NOT NULL,
  `total_recent_post_sidebar` int(11) NOT NULL,
  `total_popular_post_sidebar` int(11) NOT NULL,
  `total_featured_product_home` int(11) NOT NULL,
  `total_latest_product_home` int(11) NOT NULL,
  `total_popular_product_home` int(11) NOT NULL,
  `meta_title_home` text NOT NULL,
  `meta_keyword_home` text NOT NULL,
  `meta_description_home` text NOT NULL,
  `banner_login` varchar(255) NOT NULL,
  `banner_registration` varchar(255) NOT NULL,
  `banner_forget_password` varchar(255) NOT NULL,
  `banner_reset_password` varchar(255) NOT NULL,
  `banner_search` varchar(255) NOT NULL,
  `banner_cart` varchar(255) NOT NULL,
  `banner_checkout` varchar(255) NOT NULL,
  `banner_product_category` varchar(255) NOT NULL,
  `banner_blog` varchar(255) NOT NULL,
  `cta_title` varchar(255) NOT NULL,
  `cta_content` text NOT NULL,
  `cta_read_more_text` varchar(255) NOT NULL,
  `cta_read_more_url` varchar(255) NOT NULL,
  `cta_photo` varchar(255) NOT NULL,
  `featured_product_title` varchar(255) NOT NULL,
  `featured_product_subtitle` varchar(255) NOT NULL,
  `latest_product_title` varchar(255) NOT NULL,
  `latest_product_subtitle` varchar(255) NOT NULL,
  `popular_product_title` varchar(255) NOT NULL,
  `popular_product_subtitle` varchar(255) NOT NULL,
  `testimonial_title` varchar(255) NOT NULL,
  `testimonial_subtitle` varchar(255) NOT NULL,
  `testimonial_photo` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_subtitle` varchar(255) NOT NULL,
  `newsletter_text` text NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `stripe_public_key` varchar(255) NOT NULL,
  `stripe_secret_key` varchar(255) NOT NULL,
  `bank_detail` text NOT NULL,
  `before_head` text NOT NULL,
  `after_body` text NOT NULL,
  `before_body` text NOT NULL,
  `home_service_on_off` int(11) NOT NULL,
  `home_welcome_on_off` int(11) NOT NULL,
  `home_featured_product_on_off` int(11) NOT NULL,
  `home_latest_product_on_off` int(11) NOT NULL,
  `home_popular_product_on_off` int(11) NOT NULL,
  `home_testimonial_on_off` int(11) NOT NULL,
  `home_blog_on_off` int(11) NOT NULL,
  `newsletter_on_off` int(11) NOT NULL,
  `ads_above_welcome_on_off` int(1) NOT NULL,
  `ads_above_featured_product_on_off` int(1) NOT NULL,
  `ads_above_latest_product_on_off` int(1) NOT NULL,
  `ads_above_popular_product_on_off` int(1) NOT NULL,
  `ads_above_testimonial_on_off` int(1) NOT NULL,
  `ads_category_sidebar_on_off` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `logo`, `favicon`, `footer_about`, `footer_copyright`, `contact_address`, `contact_email`, `contact_phone`, `contact_fax`, `contact_map_iframe`, `receive_email`, `receive_email_subject`, `receive_email_thank_you_message`, `forget_password_message`, `total_recent_post_footer`, `total_popular_post_footer`, `total_recent_post_sidebar`, `total_popular_post_sidebar`, `total_featured_product_home`, `total_latest_product_home`, `total_popular_product_home`, `meta_title_home`, `meta_keyword_home`, `meta_description_home`, `banner_login`, `banner_registration`, `banner_forget_password`, `banner_reset_password`, `banner_search`, `banner_cart`, `banner_checkout`, `banner_product_category`, `banner_blog`, `cta_title`, `cta_content`, `cta_read_more_text`, `cta_read_more_url`, `cta_photo`, `featured_product_title`, `featured_product_subtitle`, `latest_product_title`, `latest_product_subtitle`, `popular_product_title`, `popular_product_subtitle`, `testimonial_title`, `testimonial_subtitle`, `testimonial_photo`, `blog_title`, `blog_subtitle`, `newsletter_text`, `paypal_email`, `stripe_public_key`, `stripe_secret_key`, `bank_detail`, `before_head`, `after_body`, `before_body`, `home_service_on_off`, `home_welcome_on_off`, `home_featured_product_on_off`, `home_latest_product_on_off`, `home_popular_product_on_off`, `home_testimonial_on_off`, `home_blog_on_off`, `newsletter_on_off`, `ads_above_welcome_on_off`, `ads_above_featured_product_on_off`, `ads_above_latest_product_on_off`, `ads_above_popular_product_on_off`, `ads_above_testimonial_on_off`, `ads_category_sidebar_on_off`) VALUES
(1, 'logo.png', 'favicon.png', '<p>Lorem ipsum dolor sit amet, omnis signiferumque in mei, mei ex enim concludaturque. Senserit salutandi euripidis no per, modus maiestatis scribentur est an.Â Ea suas pertinax has.</p>\r\n', 'Copyright Â© 2023 Unit Pharma. All Rights Reserved.', '725 Milford \r\nMt. Pleasant Road\r\nMilford , New Jersey  08848\r\nUnited States', 'support@unitpharma.com', '+1 (903) 429-5515', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3029.9585924651283!2d-75.05990539999999!3d40.5866694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c40b7fc1c6dfeb%3A0xf713119b0b5fa281!2s725%20Milford%20Mt%20Pleasant%20Rd%2C%20Milford%2C%20NJ%2008848%2C%20USA!5e0!3m2!1sen!2sin!4v1677488263714!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'support@unitpharma.com', 'Visitor Email Message from unitpharma.com', 'Thank you for sending email. We will contact you shortly.', 'A confirmation link is sent to your email address. You will get the password reset information in there.', 4, 4, 5, 5, 8, 6, 8, 'Unit Pharma', 'online medical store, medicine shop, online medicine, pharmacy', 'Unit Pharma is a trusted online pharmacy in the USA. Unit Pharma provides high-quality painkillers, anxiety medicines, sleeping pills, sexual wellness medicines, and gym products at the best price.', 'banner_login.jpg', 'banner_registration.jpg', 'banner_forget_password.jpg', 'banner_reset_password.jpg', 'banner_search.jpg', 'banner_cart.jpg', 'banner_checkout.jpg', 'banner_product_category.jpg', 'banner_blog.jpg', 'Welcome To Our Ecommerce Website', 'Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, \r\nat usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. ', 'Read More', '#', 'cta.jpg', 'Featured Products', 'Our list on Top Featured Products', 'Latest Products', 'Our list of recently added products', 'Popular Products', 'Popular products based on customer\'s choice', 'Testimonials', 'See what our clients tell about us', 'testimonial.jpg', 'Latest Blog', 'See all our latest articles and news from below', 'Sign-up to our newsletter for latest promotions and discounts.', 'support@unitpharma.com', 'pk_test_0SwMWadgu8DwmEcPdUPRsZ7b', 'sk_test_TFcsLJ7xxUtpALbDo1L5c1PN', '***', '<link href=\'https://fonts.googleapis.com/css?family=Poppins rel=\'stylesheet\'>\r\n<style>\r\nbody {\r\n font-family: \'Poppins\', \'Verdana\';\r\n}\r\n</style>', '', '<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/63e7b3abc2f1ac1e2032b8a6/1gp0hblqn\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_cost`
--

CREATE TABLE `tbl_shipping_cost` (
  `shipping_cost_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_cost_all`
--

CREATE TABLE `tbl_shipping_cost_all` (
  `sca_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shipping_cost_all`
--

INSERT INTO `tbl_shipping_cost_all` (`sca_id`, `amount`) VALUES
(1, '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `button_text` varchar(255) NOT NULL,
  `button_url` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `photo`, `heading`, `content`, `button_text`, `button_url`, `position`) VALUES
(1, 'slider-1.jpeg', 'Welcome to Unit Pharma', 'A Trusted Online Pharmacy\r\nGet the Best Quality Medicine Here', 'View Painkillers', 'product-category.php?id=8&type=top-category', 'Center'),
(2, 'slider-2.jpg', 'Order Medicine on Best Price', 'Buy a wide range of over the counter medicines online at low prices.', 'Read More', '#', 'Center'),
(3, 'slider-3.png', '24 Hours Customer Support', 'Our highly experienced representatives are available 24 hours a day and 7 days a week.', 'Read More', 'contact.php', 'Right');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social`
--

CREATE TABLE `tbl_social` (
  `social_id` int(11) NOT NULL,
  `social_name` varchar(30) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  `social_icon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_social`
--

INSERT INTO `tbl_social` (`social_id`, `social_name`, `social_url`, `social_icon`) VALUES
(1, 'Facebook', 'https://www.facebook.com/#', 'fa fa-facebook'),
(2, 'Twitter', 'https://www.twitter.com/#', 'fa fa-twitter'),
(3, 'LinkedIn', '', 'fa fa-linkedin'),
(4, 'Google Plus', '', 'fa fa-google-plus'),
(5, 'Pinterest', '', 'fa fa-pinterest'),
(6, 'YouTube', 'https://www.youtube.com/#', 'fa fa-youtube'),
(7, 'Instagram', 'https://www.instagram.com/#', 'fa fa-instagram'),
(8, 'Tumblr', '', 'fa fa-tumblr'),
(9, 'Flickr', '', 'fa fa-flickr'),
(10, 'Reddit', '', 'fa fa-reddit'),
(11, 'Snapchat', '', 'fa fa-snapchat'),
(12, 'WhatsApp', 'https://www.whatsapp.com/#', 'fa fa-whatsapp'),
(13, 'Quora', '', 'fa fa-quora'),
(14, 'StumbleUpon', '', 'fa fa-stumbleupon'),
(15, 'Delicious', '', 'fa fa-delicious'),
(16, 'Digg', '', 'fa fa-digg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscriber`
--

CREATE TABLE `tbl_subscriber` (
  `subs_id` int(11) NOT NULL,
  `subs_email` varchar(255) NOT NULL,
  `subs_date` varchar(100) NOT NULL,
  `subs_date_time` varchar(100) NOT NULL,
  `subs_hash` varchar(255) NOT NULL,
  `subs_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_top_category`
--

CREATE TABLE `tbl_top_category` (
  `tcat_id` int(11) NOT NULL,
  `tcat_name` varchar(255) NOT NULL,
  `show_on_menu` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_top_category`
--

INSERT INTO `tbl_top_category` (`tcat_id`, `tcat_name`, `show_on_menu`) VALUES
(10000, 'Anxiety', 1),
(10001, 'Painkillers', 1),
(10002, 'Gym Products', 0),
(10003, 'Sleeping Pills', 1),
(10004, 'Sexual Wellness', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `full_name`, `email`, `phone`, `password`, `photo`, `role`, `status`) VALUES
(1, 'Administrator', 'admin@mail.com', '7777777777', 'b17f63abfdf8aa0108fd3873a3b43bd7', 'user-1.jpg', 'Super Admin', 1),
(2, 'Christine', 'christine@mail.com', '4444444444', '81dc9bdb52d04dc20036dbd8313ed055', 'user-2.png', 'Admin', 1),
(4, 'Administrator', 'adminup@mail.com', '', '57936a92df81a35aec87062281b5e15a', 'user-4.jpg', 'Super Admin', 1),
(5, 'Admin', 'up.admin@mail.com', '', 'b1c74d1f62eee4fd57c75f0684791852', 'user-5.png', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `iframe_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `tbl_country`
--
ALTER TABLE `tbl_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `tbl_customer_message`
--
ALTER TABLE `tbl_customer_message`
  ADD PRIMARY KEY (`customer_message_id`);

--
-- Indexes for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  ADD PRIMARY KEY (`ecat_id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  ADD PRIMARY KEY (`mcat_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page`
--
ALTER TABLE `tbl_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_package`
--
ALTER TABLE `tbl_product_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_photo`
--
ALTER TABLE `tbl_product_photo`
  ADD PRIMARY KEY (`pp_id`);

--
-- Indexes for table `tbl_product_size`
--
ALTER TABLE `tbl_product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`rt_id`);

--
-- Indexes for table `tbl_service`
--
ALTER TABLE `tbl_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shipping_cost`
--
ALTER TABLE `tbl_shipping_cost`
  ADD PRIMARY KEY (`shipping_cost_id`);

--
-- Indexes for table `tbl_shipping_cost_all`
--
ALTER TABLE `tbl_shipping_cost_all`
  ADD PRIMARY KEY (`sca_id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social`
--
ALTER TABLE `tbl_social`
  ADD PRIMARY KEY (`social_id`);

--
-- Indexes for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  ADD PRIMARY KEY (`subs_id`);

--
-- Indexes for table `tbl_top_category`
--
ALTER TABLE `tbl_top_category`
  ADD PRIMARY KEY (`tcat_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_country`
--
ALTER TABLE `tbl_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;
--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_customer_message`
--
ALTER TABLE `tbl_customer_message`
  MODIFY `customer_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tbl_end_category`
--
ALTER TABLE `tbl_end_category`
  MODIFY `ecat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT for table `tbl_mid_category`
--
ALTER TABLE `tbl_mid_category`
  MODIFY `mcat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_page`
--
ALTER TABLE `tbl_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10010;
--
-- AUTO_INCREMENT for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10021;
--
-- AUTO_INCREMENT for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_product_package`
--
ALTER TABLE `tbl_product_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10146;
--
-- AUTO_INCREMENT for table `tbl_product_photo`
--
ALTER TABLE `tbl_product_photo`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10023;
--
-- AUTO_INCREMENT for table `tbl_product_size`
--
ALTER TABLE `tbl_product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  MODIFY `rt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10078;
--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_shipping_cost`
--
ALTER TABLE `tbl_shipping_cost`
  MODIFY `shipping_cost_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_shipping_cost_all`
--
ALTER TABLE `tbl_shipping_cost_all`
  MODIFY `sca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_social`
--
ALTER TABLE `tbl_social`
  MODIFY `social_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_subscriber`
--
ALTER TABLE `tbl_subscriber`
  MODIFY `subs_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_top_category`
--
ALTER TABLE `tbl_top_category`
  MODIFY `tcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
