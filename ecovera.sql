/*
Navicat Premium Dump SQL

Source Server         : Localhost
Source Server Type    : MySQL
Source Server Version : 80041 (8.0.41)
Source Host           : localhost:3306
Source Schema         : ecovera

Target Server Type    : MySQL
Target Server Version : 80041 (8.0.41)
File Encoding         : 65001

Date: 29/01/2026 16:36:30
*/

SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for cart_items
-- ----------------------------
DROP TABLE IF EXISTS `cart_items`;

CREATE TABLE `cart_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12, 2) NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cart_items_cart_id_foreign`(`cart_id` ASC) USING BTREE,
  INDEX `cart_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `cart_items_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cart_items
-- ----------------------------

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;

CREATE TABLE `carts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `carts_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `carts_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of carts
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `categories_uuid_index`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (9, '160c6695-7645-499f-8736-e6eb8b7c074e', 'Peralatan Kampus', 'peralatan-kampus', 'categories/69759e94f1f3c.png', 'Temukan Peralatan Kampus Sesuai Kebutuhan Kamu', 1, '2026-01-25 12:39:50', '2026-01-25 12:39:50');

INSERT INTO `categories` VALUES (10, '1fb70f7e-321c-4707-bbd8-cdd680420d9e', 'Perabotan Kost', 'perabotan-kost', 'categories/69759eb4a90c3.png', 'Temukan Perabotan Kos Sesuai Kebutuhan Kamu', 1, '2026-01-25 12:40:20', '2026-01-25 12:40:20');

INSERT INTO `categories` VALUES (11, 'ae52c936-828c-4de1-9c8f-9fb55cd99708', 'Elektronik', 'elektronik', 'categories/69759ed0c5d99.png', 'Temukan Peralatan Elektronik Sesuai Kebutuhan Kamu', 1, '2026-01-25 12:40:48', '2026-01-25 12:40:48');

INSERT INTO `categories` VALUES (12, 'c75b43b5-6765-4e0e-9cf8-f24125324654', 'Eco Fashion', 'eco-fashion', 'categories/69759eec97fa8.webp', 'Temukan Fashion Ramah Lingkungan Sesuai Kebutuhan Kamu', 1, '2026-01-25 12:41:16', '2026-01-25 12:41:16');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);

INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);

INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);

INSERT INTO `migrations` VALUES (4, '2026_01_18_022705_create_password_resets_table', 1);

INSERT INTO `migrations` VALUES (5, '2026_01_18_032545_create_stores_table', 1);

INSERT INTO `migrations` VALUES (6, '2026_01_18_032546_create_categories_table', 1);

INSERT INTO `migrations` VALUES (7, '2026_01_18_032607_create_products_table', 1);

INSERT INTO `migrations` VALUES (8, '2026_01_18_032624_create_product_images_table', 1);

INSERT INTO `migrations` VALUES (9, '2026_01_18_032643_create_carts_table', 1);

INSERT INTO `migrations` VALUES (10, '2026_01_18_032705_create_cart_items_table', 1);

INSERT INTO `migrations` VALUES (11, '2026_01_18_032720_create_orders_table', 1);

INSERT INTO `migrations` VALUES (12, '2026_01_18_032737_create_order_items_table', 1);

INSERT INTO `migrations` VALUES (13, '2026_01_18_032805_create_payments_table', 1);

INSERT INTO `migrations` VALUES (14, '2026_01_18_032822_create_shipments_table', 1);

INSERT INTO `migrations` VALUES (15, '2026_01_18_032843_create_returns_table', 1);

INSERT INTO `migrations` VALUES (16, '2026_01_18_032858_create_return_items_table', 1);

INSERT INTO `migrations` VALUES (17, '2026_01_18_032919_create_return_shipments_table', 1);

INSERT INTO `migrations` VALUES (18, '2026_01_18_032936_create_refunds_table', 1);

INSERT INTO `migrations` VALUES (19, '2026_01_18_032957_create_reviews_table', 1);

INSERT INTO `migrations` VALUES (20, '2026_01_18_033517_create_user_addresses_table', 1);

INSERT INTO `migrations` VALUES (21, '2026_01_18_033608_create_order_addresses_table', 1);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12, 2) NOT NULL,
  `subtotal` decimal(12, 2) NOT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_items_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `order_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `order_items_seller_id_foreign`(`seller_id` ASC) USING BTREE,
  INDEX `order_items_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_items_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` VALUES (9, 'a6a2955c-37b1-4873-b324-1b48dc3c8bcb', 5, 19, 2, 1, 120200.00, 120200.00, NULL, NULL);

INSERT INTO `order_items` VALUES (10, '2352ef43-9cef-45c0-85eb-bfb9379ac545', 5, 21, 2, 1, 509000.00, 509000.00, NULL, NULL);

INSERT INTO `order_items` VALUES (11, '024cc2e0-d2cd-4eb4-bfa3-1887573310db', 6, 16, 2, 1, 89000.00, 89000.00, NULL, NULL);

INSERT INTO `order_items` VALUES (12, 'b77d84de-156a-4a62-b15b-ece376b6855c', 6, 19, 2, 1, 120200.00, 120200.00, NULL, NULL);

INSERT INTO `order_items` VALUES (13, '8404ca30-a283-4d79-87a3-1a4b9cfce236', 7, 16, 2, 1, 89000.00, 89000.00, NULL, NULL);

INSERT INTO `order_items` VALUES (14, 'f72b1608-767d-4b17-b55e-80c255e031ee', 7, 21, 2, 1, 509000.00, 509000.00, NULL, NULL);

INSERT INTO `order_items` VALUES (15, '50b88d56-3556-43e8-acdb-76f5bc13d246', 8, 11, 2, 1, 499000.00, 499000.00, NULL, NULL);

INSERT INTO `order_items` VALUES (16, '643f9c7b-4fb0-4cbb-86c3-f51534b57422', 8, 23, 2, 1, 435000.00, 435000.00, NULL, NULL);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_code` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `total_amount` decimal(12, 2) NOT NULL,
  `shipping_cost` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12, 2) NOT NULL,
  `status` enum('pending','paid','processed','shipped','completed','cancelled','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `orders_order_code_unique`(`order_code` ASC) USING BTREE,
  INDEX `orders_buyer_id_foreign`(`buyer_id` ASC) USING BTREE,
  INDEX `orders_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (5, '8900d290-b638-4f3e-ad2f-464912493586', 'ORD-1769335589', 2, 629200.00, 0.00, 629200.00, 'pending', 'midtrans', '2026-01-25 18:06:29', '2026-01-25 18:06:29');

INSERT INTO `orders` VALUES (6, 'fd13747f-d127-49a9-82da-411aef73ae6f', 'ORD-1769335938', 2, 209200.00, 0.00, 209200.00, 'pending', 'midtrans', '2026-01-25 18:12:18', '2026-01-25 18:12:18');

INSERT INTO `orders` VALUES (7, '1a8622ab-7584-440e-9536-9feee5df9fa9', 'ORD-1769336122', 2, 598000.00, 0.00, 598000.00, 'pending', 'midtrans', '2026-01-25 18:15:22', '2026-01-25 18:15:22');

INSERT INTO `orders` VALUES (8, '89b22fbf-517a-47b9-97e7-09c6994c4c72', 'ORD-1769336187', 2, 934000.00, 0.00, 934000.00, 'pending', 'midtrans', '2026-01-25 18:16:27', '2026-01-25 18:16:27');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `amount` decimal(12, 2) NOT NULL,
  `payment_status` enum('pending','success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `payments_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `payments_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` VALUES (2, '119a018e-cd7a-4732-9b38-3bfc2d966e06', 5, 'midtrans', NULL, 629200.00, 'pending', NULL, NULL, NULL);

INSERT INTO `payments` VALUES (3, '5b58e2b7-0f2d-49ff-a07a-4c10062685b4', 6, 'midtrans', NULL, 209200.00, 'pending', NULL, NULL, NULL);

INSERT INTO `payments` VALUES (4, '4262cd5f-12ae-493e-8a79-5fa4471e2d10', 7, 'midtrans', NULL, 598000.00, 'pending', NULL, NULL, NULL);

INSERT INTO `payments` VALUES (5, 'b9afb238-4408-4046-88d0-04ffaa54000a', 8, 'midtrans', NULL, 934000.00, 'pending', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for product_images
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;

CREATE TABLE `product_images`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_images_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `product_images_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 126 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_images
-- ----------------------------
INSERT INTO `product_images` VALUES (19, '894881c4-7bea-4621-ace6-59ddbe2ebba9', 6, 'products/images/wPr8l30wFEbhS1N8TmtZfGMRJGaUaYMc2sRJh6KH.jpg', NULL, 1, '2026-01-25 14:23:30', '2026-01-25 14:23:30');

INSERT INTO `product_images` VALUES (20, 'f97b8392-5514-4ba5-88bd-c20dbe77c44a', 6, 'products/images/zkluNK9gejwLL0VDMedwWWyH22YLNrmT0EHm6oVt.jpg', NULL, 0, '2026-01-25 14:23:30', '2026-01-25 14:23:30');

INSERT INTO `product_images` VALUES (21, 'fcbe97ab-6ae6-4750-8f58-e4de1e7933b8', 6, 'products/images/WX66rYVZpFmsgw2G2B33An916SHKGBaAljmm4FOz.jpg', NULL, 0, '2026-01-25 14:23:30', '2026-01-25 14:23:30');

INSERT INTO `product_images` VALUES (22, '8c7ae9a1-696d-42f1-9139-5ecf55c51cde', 6, 'products/images/w0vxz2ZQEehGMGyhJX2oP7tGFWjBrLb2dX0b7kHO.jpg', NULL, 0, '2026-01-25 14:23:30', '2026-01-25 14:23:30');

INSERT INTO `product_images` VALUES (23, '71c0b38a-795a-4611-84a4-d19840dbd72c', 7, 'products/images/Pberx6uaijBeytFVALMNxxKtQ62II5LmwhAy8Wso.jpg', NULL, 1, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (24, '41ebec5b-7231-4a0c-a612-da1f54b35087', 7, 'products/images/XiB4JTAt8K31nuMhxDVnZf0LKDu4VcfDwvPxNQYK.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (25, 'a769cb20-379b-426c-9886-afebd1829a16', 7, 'products/images/slfzNpIhm02ayeSkfcqyChhjvohJ7KYJBWWa02V8.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (26, 'cead41db-9eeb-48a0-8d6d-6d1cb679f3c3', 7, 'products/images/4qYlKP4CcbeC14pITXnjulqVuHokmusO69JulURy.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (27, '0dd3853a-b6a4-4a22-ad5f-e8ec3a357422', 7, 'products/images/6MMsFSiENulIeH77rqs1LaEcLnT55BTV3W2OjYdi.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (28, 'dd66bdd6-3de2-408e-9cd3-221fbbddfb33', 7, 'products/images/3SRpR0FtDgi6iOkjc7ZWcCv1bP0zS8D7FBxMGXRh.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (29, '81a70a56-6038-41c3-a7e2-05f5d1549bfb', 7, 'products/images/k3GIwMuH1wDCMxYSGrPf4nBvry9NgYFAtKlOXQLT.jpg', NULL, 0, '2026-01-25 14:28:47', '2026-01-25 14:28:47');

INSERT INTO `product_images` VALUES (30, '4ea3b269-e2ee-4d89-b857-2aec62f97238', 8, 'products/images/puxmMjAqSxeITvnoVrcTPqF2B7KGbumy0ffPFX79.jpg', NULL, 1, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (31, '43636b07-a063-40a8-a82d-eb58072222a3', 8, 'products/images/IT7JoWuJHAAKUMbrGFH44bpKeW9V45GcFaswsQau.jpg', NULL, 0, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (32, 'fb53c99a-6711-456c-b5a5-5c0a75f782e5', 8, 'products/images/pWDMiVVoeoeHiNXiwdqUa6Tzb22ZNp8C8P9L4wkM.jpg', NULL, 0, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (33, '8b612811-d94c-473c-bf31-8a5b4a537a3b', 8, 'products/images/OVwvJIJtAmj8KYNo19saGWGbPtKuIrJMKTGgE9m9.jpg', NULL, 0, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (34, '315ce818-a61a-4263-8e9a-ce6b40b4fd01', 8, 'products/images/q4pFR0T8C1dyLrypghUQFyBz3n9YUgK7qcDExPmN.jpg', NULL, 0, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (35, 'd4230c2f-0be4-4b23-8bde-45cf52202437', 8, 'products/images/cmV7Z63QQtagR9rk6RGnvub4jrokc5BWfgqoZfuf.jpg', NULL, 0, '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `product_images` VALUES (36, '6ff2c804-a334-4796-9e7c-0cd54933aebe', 9, 'products/images/3Wu57MYY067foJga7mKIr31w2b1hu3mdQr8RYYuj.jpg', NULL, 1, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (37, 'b06fcea6-ea6b-4a79-a3fc-a92e2e48f236', 9, 'products/images/y8ymO9vPcrlEJlTluz27p6cTTmHTPLUCd5eB92q3.jpg', NULL, 0, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (38, '4fedde4e-d256-48d9-9753-b603d666b53b', 9, 'products/images/W7Z6S48uQWq8oOLi3I299q7at0gU7zkwXcjkGJIh.jpg', NULL, 0, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (39, 'd9cb00a8-eb24-4dc9-8821-83b3f87cb2b7', 9, 'products/images/KSh7l5w2yds1InlK4lcWpHID4o7vGLWYRKTiKYaB.jpg', NULL, 0, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (40, '57611948-3e40-48b9-9acb-bf7036c19b04', 9, 'products/images/COGJkvyEtJaywU86DtWFyACMnfetyGuzXVEdciuO.jpg', NULL, 0, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (41, 'd0e2ed33-74e0-44e6-be26-3b895256a2e8', 9, 'products/images/TIA3kfDtW2SDY7w38fJJJP4aNAtRovyoBRYXxjp1.jpg', NULL, 0, '2026-01-25 14:33:32', '2026-01-25 14:33:32');

INSERT INTO `product_images` VALUES (42, '60c0a762-2526-41f1-b13b-179eca825043', 10, 'products/images/o8bqQ1PG07wbg6XsbTU16xWMq58EsQ5X9hT5Fk6g.jpg', NULL, 1, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (43, '88d89303-6bc4-42ac-9cf0-91f68d1fe98d', 10, 'products/images/SQloYbMmITnsAq61WYzm98OISxMtJXgUiOQGVH8b.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (44, '215fbf7a-05e3-47dc-bace-89db15695466', 10, 'products/images/JXgU88AcmvTIWOJL2tWVv0vpSRyGY47BfV5s1cjD.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (45, 'd04fbed4-03fa-4478-a17e-1dd814f1d094', 10, 'products/images/3dYMdXiGnPLSMfrQcS7PocQQfAoEpWJ3WAbMGPhE.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (46, '7835ad02-4a38-4264-b8db-1afa8be21aaa', 10, 'products/images/VZQg9GcZBACAV9gKoCalIpIdQYmbPps1hwMM9VUJ.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (47, 'ba8f69cc-8196-484f-a275-c1552237ffd6', 10, 'products/images/VHXC25feeDzO300c7jsdGbvGMVw1m4fmDrYL2NhY.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (48, '2c0176d5-f1dd-45be-b1a1-a22764f857a8', 10, 'products/images/Xj51zxRmz6PrxdUCrxUkcGH9NodZvL4OMuskhRD6.jpg', NULL, 0, '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `product_images` VALUES (49, 'f813863f-5ff3-41bb-b1a7-1c7d130b9ef2', 11, 'products/images/FBvAV93HoBa1BYCLtdC0WrGwyvyuCq36aqhUpr67.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (50, '2a58ea5f-2594-4d15-96aa-aa2cc5339251', 11, 'products/images/KRjb5dwHaAtMDjg8ZyyJ4igl8wT5t2wWv32rsUlM.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (51, '32a53c07-bae8-477d-b2a0-30450e600e7e', 11, 'products/images/9xOq6BU8ZHwkrRhHC0qKGCeWnaY7BiqEF2np2zlN.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (52, '7cf1d421-f92d-41d5-aebc-b99875856078', 11, 'products/images/wUadorzMMAS3xZo19C0NibO6nQzZKY1SVxRGoAlK.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (53, 'eca5d8b3-288a-4970-b396-9aea8f41724f', 11, 'products/images/Zeeb6ILDcIAHYkkp0IRlreMahkzTMaF7hrzjPYqQ.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (54, '411ecc52-02bd-4873-a205-d7fb0c993f76', 11, 'products/images/40vEjSuXRoze5kw9QS8C7l6Ly5Nsy9DN5Hfp8cq2.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (55, 'ecc6fb0c-4d4f-41e4-aa36-a9d43806d210', 11, 'products/images/UL1nscBF6zGimYyIgYOjELsk8Us3RWslnb8GTXz4.jpg', NULL, 0, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (56, '298e0154-1d16-4ad4-8d84-dd2514a83029', 11, 'products/images/jsxVIEyUnPYXcpvZh9lqqKNWhj4Z2tOOzi0BErk1.jpg', NULL, 1, '2026-01-25 14:37:59', '2026-01-25 14:37:59');

INSERT INTO `product_images` VALUES (57, 'aab9c36e-b25e-49bc-979a-2ca79750d5a8', 12, 'products/images/iM5C4K8kpqsM7veDuMiJeriJFBBDAxCdTaHX3kuH.jpg', NULL, 1, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (58, 'aaec277a-0bf8-4236-afca-ebc23ac64d28', 12, 'products/images/ml8EwGHUBLRlAGbkIqj8mkk7UKlnpPyBDujLxvqJ.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (59, '1d13ee8b-f431-43d2-845e-30b8d0f38023', 12, 'products/images/fcbMnyEY7kveLfTNVd9AX3r1xVjyI56yw9YfUqlf.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (60, '4a993be9-96eb-421e-bf2e-59489a904fa6', 12, 'products/images/qRIdlTCXRz2Co8Dec9JUXyWMs5KxjzEUioatftF0.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (61, '4ce956ff-dc85-4c1e-ae29-b8e7dbc4cccb', 12, 'products/images/glGM4yv7RiXaWuKlneMN1Ni9KmQ9wUX2ttniDtUb.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (62, 'f33f1b94-62c5-4d5e-9755-922276b8fb04', 12, 'products/images/hOl1Z4HLTrH1Fnj8uIKcoXhQXxRHIBZ76XGmyWVi.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (63, '5afe3afb-b4e8-45b1-8626-4d146895d2fd', 12, 'products/images/10dq515D6T3oYDgMyovIs9OcIj4YogChqcYf11A8.jpg', NULL, 0, '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `product_images` VALUES (64, '94bfb1c5-69c6-4333-8cd4-253206819378', 13, 'products/images/qG3jug6tQylSJ2XdQtbTvwpNBTdWpiGNEejTqdOG.jpg', NULL, 1, '2026-01-25 14:42:22', '2026-01-25 14:42:22');

INSERT INTO `product_images` VALUES (65, '82eb9df9-f419-441c-a5d3-f8478238fa80', 13, 'products/images/K7CVBIrcI1NtIMTGBMN4HmrAU97yZFUO5VuDGAKn.jpg', NULL, 0, '2026-01-25 14:42:22', '2026-01-25 14:42:22');

INSERT INTO `product_images` VALUES (66, '117defb5-30fa-4397-ae22-59f9f38d983e', 13, 'products/images/VksJTYOZmQPleo48IxFS2E4WQwGAojlzAxYwfbT8.jpg', NULL, 0, '2026-01-25 14:42:22', '2026-01-25 14:42:22');

INSERT INTO `product_images` VALUES (67, '2c561263-c00c-40c4-9eb6-5f7501894142', 14, 'products/images/OOkAcpgfFqIl2C5RarWroUpnVfWyZyOdfa54tUEN.jpg', NULL, 1, '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `product_images` VALUES (68, 'c8f89f1a-b7ac-47e1-b738-d545cfb5aedb', 14, 'products/images/vb06cw5LeprPD3t4OFdQcwCTUoVVr3Ln69TN4AYp.jpg', NULL, 0, '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `product_images` VALUES (69, '413cd7aa-06a5-47ee-8058-7b02b6abb476', 14, 'products/images/gz7kNvmwigEF3AtUjvE0VBJ83C6t5rn3egK7F5yp.jpg', NULL, 0, '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `product_images` VALUES (70, '9993cc37-c042-48a4-a6e5-279ee6d7f16e', 14, 'products/images/EgWjsWE0QGvPjCUMuYxqnc8WdxIgPXfluCaY85tW.jpg', NULL, 0, '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `product_images` VALUES (71, '8ef09fd1-58a7-4764-a1d8-de82d17a309b', 14, 'products/images/U8nOtPi4OmbVMdPTfhiQfjnAql88tq4UtFVhWzWu.jpg', NULL, 0, '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `product_images` VALUES (72, 'f831e1ff-573e-4b0f-941d-57082080f047', 15, 'products/images/JQmVfqXiWMY7A7No88ZSXVTHerqYDdAXwogfdQO2.jpg', NULL, 1, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (73, 'cd857b89-0626-4f49-9b5e-c90679d2db6e', 15, 'products/images/7rmgCRn6idedRFqrYHEmew7HFYJFSBsMfXI8qy5S.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (74, '4bcedb68-3248-4ee9-a83a-f88189b7f78e', 15, 'products/images/OgM4FwgiQt85FLP2T2Lc2ukjWhYRDehpedsBtBmF.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (75, 'c0494b2a-fcbb-4fff-b2d4-00485751dc5d', 15, 'products/images/CzbBi62BNM5EghAmsLtxF9AGrCjDwuwOxi3jFxs9.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (76, '926b2a80-d7c7-4cd4-9be3-e06d2d7ba685', 15, 'products/images/tfm6kcZxbeGVxeMyS806MzXb4MA5LrDlUGN2NaCK.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (77, 'ed7d8fcc-99f1-4253-9198-1e1beda649f2', 15, 'products/images/asEtn9nhGvPUTvBi56JVQ4ez6NoVRLGno9ODucve.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (78, 'ce7e05e4-61b0-4181-a997-1ba7283d3ab6', 15, 'products/images/ygenjSkp3MhvILaZlJToljBd8IXhpLKOTSZD6klE.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (79, 'f5257407-ccde-43cc-9c2f-d47689af730f', 15, 'products/images/0Po2JmTAZcLhDGDKIKQyoZaHDnaNnHkz5UKbwFfa.jpg', NULL, 0, '2026-01-25 14:45:30', '2026-01-25 14:45:30');

INSERT INTO `product_images` VALUES (80, 'd3446545-10e1-4998-a072-66400808d988', 16, 'products/images/2sLbqM0yBua4gmeLy2Cfi6l5Rc6IjvgqYTZMKDFR.jpg', NULL, 0, '2026-01-25 14:46:33', '2026-01-25 14:46:33');

INSERT INTO `product_images` VALUES (81, '75d6653f-9da9-4150-b27a-4d462dc5aef0', 16, 'products/images/043aR84hBbBSj6RZUTFPlJJQPFTJz7bh1SVsDs96.jpg', NULL, 0, '2026-01-25 14:46:33', '2026-01-25 14:46:33');

INSERT INTO `product_images` VALUES (82, '57a6aab3-cc07-4c60-b95c-12409f543fd6', 16, 'products/images/1iqahy3fu8JUeYieRzRwiixUPcKlJpJCvJ50p6dj.jpg', NULL, 1, '2026-01-25 14:46:33', '2026-01-25 14:46:33');

INSERT INTO `product_images` VALUES (83, 'e30cee5a-9b6e-4458-8e2d-9166662f388c', 17, 'products/images/Iy5nBZ3StYKrhMQaVUcrRu4jWdwscfEg7F7bQAq9.jpg', NULL, 0, '2026-01-25 14:54:22', '2026-01-25 14:54:22');

INSERT INTO `product_images` VALUES (84, 'c109ecc0-383f-4c6a-a741-a68af6961013', 17, 'products/images/JjBzYdmjiTQeTxc6my0vc7M5I0g1Je0c5k3jJxlf.jpg', NULL, 0, '2026-01-25 14:54:22', '2026-01-25 14:54:22');

INSERT INTO `product_images` VALUES (85, '8fbdf450-7b24-4784-b6c0-52ff1a2d5f4e', 17, 'products/images/c5huFisWzTFd8nw6YDJmUiS2AqIquORpkswunQvp.jpg', NULL, 0, '2026-01-25 14:54:22', '2026-01-25 14:54:22');

INSERT INTO `product_images` VALUES (86, 'af67e8cb-b819-47f2-a446-9f5ea7d3a39a', 17, 'products/images/VyhfFOebVgkRoRuQShkTMAjKqdwYf9WOrjfea6Vl.jpg', NULL, 1, '2026-01-25 14:54:22', '2026-01-25 14:54:22');

INSERT INTO `product_images` VALUES (87, '438d960a-8121-4e28-8471-2453a6c0fa9d', 18, 'products/images/bYkQMb5nbRnkQwgB1h7JFmbNaMZrMUAK25hK4stH.jpg', NULL, 0, '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `product_images` VALUES (88, '5b1eab17-249a-4b37-82fc-007ea57774ca', 18, 'products/images/kq43OhQZEiC0dFfZQXp8iDsVEVecKzOt5y1Gl2zQ.jpg', NULL, 0, '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `product_images` VALUES (89, '489e6ec0-7f2c-4554-a5ae-d9c2f2e90ad0', 18, 'products/images/IS2CZpH3Ap1YOWdBo1bFeNFNXw6dFDLvXfIp5WhY.jpg', NULL, 0, '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `product_images` VALUES (90, '3c12744a-eb3b-4d26-a143-ccaac615e93b', 18, 'products/images/1solEAL2Q18zgQwED9RG4K1gNITW9IGoRszt96Lp.jpg', NULL, 0, '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `product_images` VALUES (91, 'c66f43bb-4242-40b3-8c55-f4cd859d36fb', 18, 'products/images/gIkiBRCb2WkPqMKj7ydFXkIR3gXJadyut2uRkVix.jpg', NULL, 1, '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `product_images` VALUES (92, 'e78a6de2-6fc2-4d4d-bdc6-32113da8cdd3', 19, 'products/images/3JVWxc3nIR7y3hRVVB3Odn4Sx9KNob47xemusDUy.jpg', NULL, 1, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (93, '73e305e8-c30d-491a-853f-e0435ac99516', 19, 'products/images/X4hyf6FASb4eapHEcstKPMy7NdjEwNhGxT4l0uFN.jpg', NULL, 0, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (94, '04df25c5-cebc-4ab1-8d48-a865968b7d5d', 19, 'products/images/YANhyQelyzGt88w6dNUnGkP5ZmXTijHPxSgdHOBR.jpg', NULL, 0, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (95, '97ec8ad5-d919-4c67-ad11-2d1cdaa6167d', 19, 'products/images/peehpCbkMBC1FpOF2QoypCiNnWcOvRpnpM3R31pc.jpg', NULL, 0, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (96, '8c664039-8ce4-48a0-8fc5-b35585cccd94', 19, 'products/images/ti4gkl7YI8d04lS1yRh4G1Wo8MClOTUs4QdnOHiF.jpg', NULL, 0, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (97, 'f021f75d-9c96-46ac-88f9-56ecf5835ea7', 19, 'products/images/cqPdausXWhnTgjw2ckFhj0tmnKFY0GKIH6ZJClJj.jpg', NULL, 0, '2026-01-25 14:57:48', '2026-01-25 14:57:48');

INSERT INTO `product_images` VALUES (98, '868f0494-6b64-42db-b78a-597e60507218', 20, 'products/images/KH7hU9kjqlwETbmLErGLGeEuDlFnX0KVqa2KG3Fy.jpg', NULL, 0, '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `product_images` VALUES (99, 'c381c40b-8a79-40e1-b1e2-5091f4148d09', 20, 'products/images/E8RyZIhXxMFvOjTeBx2QUdDl7FlXxwekfKvdtdXo.jpg', NULL, 0, '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `product_images` VALUES (100, '33078489-b292-4ef5-8af4-0d3381a0595e', 20, 'products/images/OwPt3IdQjiYLImUztWfMFU1HejJZZ32Pkp6wiPMg.jpg', NULL, 0, '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `product_images` VALUES (101, '419a26a9-fe06-4333-b428-e1b4f62be322', 20, 'products/images/C0j0JzG125dASgYzGNmbDx3sUqC5lqkJdGOOiSAA.jpg', NULL, 0, '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `product_images` VALUES (102, 'af79b4dc-8621-4665-8a35-86c491b49eac', 20, 'products/images/k5hn6kWEqt6cf6fXUfguqV4MN0NPr6x8pPECUCPD.jpg', NULL, 1, '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `product_images` VALUES (103, '9df84058-5ae5-4306-ac53-9c3625ff8c83', 21, 'products/images/kyYonjqbybYQnIt8jJ3ExfYW9GrqIepFBOxqhiTZ.jpg', NULL, 1, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (104, 'cce85417-71e8-4be5-8048-50194885d06a', 21, 'products/images/DsnR2lDHFJQTWoAfiBueqQVyuWvT2e6loO4NmZGF.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (105, '5c03fffd-5559-424d-b931-ae17c224f28b', 21, 'products/images/783GpNpofUHVLwyTJbWwrSH5WTWpwGLFzz9RQphh.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (106, '115aa3a9-0e6b-412e-9831-1fa1d466d7c2', 21, 'products/images/wTG6MG9m1V34PrLuaWsesSEvu4xx24JbSvoJmWqz.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (107, '1779e341-0512-4f6b-9231-5b5fd5ef2d5b', 21, 'products/images/O29iPorDBR3ywIYtsSQoz6Khmo7ET14BKlOim5Yv.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (108, '012d3df8-f12f-44f4-809e-b320617fcb64', 21, 'products/images/RRtGlqQYbzF8u4rkUFL9Sv9xYkrJw7VCadr8thVq.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (109, 'f411eb31-0c41-4773-be2c-cef09cce4d18', 21, 'products/images/OCVdvPjXOU8cGZNcOkbRXOLjsRZ4CvycBrvluwHP.jpg', NULL, 0, '2026-01-25 15:02:12', '2026-01-25 15:02:12');

INSERT INTO `product_images` VALUES (110, '66c134ff-886f-4a75-8f82-ec2a0a5f73e9', 22, 'products/images/crZQozZFb9R9sBpYMWmCGBRk2ynlHBgbMvO654Vi.jpg', NULL, 1, '2026-01-25 15:03:19', '2026-01-25 15:03:19');

INSERT INTO `product_images` VALUES (111, '2ddc17c7-db67-4fb9-b2db-932fb8f64abb', 22, 'products/images/9fbpduYLfe3nXL4sA7rPP68mMMgdYiWN0JFMhMSk.jpg', NULL, 0, '2026-01-25 15:03:20', '2026-01-25 15:03:20');

INSERT INTO `product_images` VALUES (112, 'a49a0a44-84cc-4ce7-90cb-9253a5d53357', 23, 'products/images/K4IQP3InFYoCGRyOX9NiaBuDAnMPKZdZhmPhanJX.jpg', NULL, 0, '2026-01-25 15:05:04', '2026-01-25 15:05:04');

INSERT INTO `product_images` VALUES (113, '2dbcf137-1921-4467-b677-5bf83155e71a', 23, 'products/images/ECoz8paadx2pmbd0PPqbSQaRDgogF2js4ZYfIG6Y.jpg', NULL, 0, '2026-01-25 15:05:04', '2026-01-25 15:05:04');

INSERT INTO `product_images` VALUES (114, 'fe1f7d4f-9ac5-4fdb-ab8d-86928c037c74', 23, 'products/images/KRJq8LyrJcSYUqnRqQIrGSz0UYLLB157STkNQOWO.jpg', NULL, 0, '2026-01-25 15:05:04', '2026-01-25 15:05:04');

INSERT INTO `product_images` VALUES (115, 'ede183e5-115c-423c-8e92-e6c075b97588', 23, 'products/images/WlW75MnfrXDZw9MQcg5kZKgjt3LWFmjETjA74PrU.jpg', NULL, 0, '2026-01-25 15:05:04', '2026-01-25 15:05:04');

INSERT INTO `product_images` VALUES (116, 'c8914b50-5a06-4bd4-b765-ed5f0ba3137b', 23, 'products/images/06CdZ7XPiZjGi4DGVwxvZJ6imPw7VSecsOdlCc1H.jpg', NULL, 1, '2026-01-25 15:05:04', '2026-01-25 15:05:04');

INSERT INTO `product_images` VALUES (117, '5481b245-79ee-461f-890e-3e354cf95896', 24, 'products/images/FoLdvSeNjAm7RZeB4jg0VqvXbvirQlfq9p5vEatW.jpg', NULL, 0, '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `product_images` VALUES (118, 'a30540df-bbe3-4da4-b843-b73ac75a2f7c', 24, 'products/images/c6RsHV3yozb9xDdfl3HJBSH9wN5TvIgB0rKQVJot.jpg', NULL, 0, '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `product_images` VALUES (119, 'e39c5cc0-5724-4d52-8e46-654ee90286a8', 24, 'products/images/FTwDLRON07aw36UjbFXJBSxaC4JnXjwamuJhTXR1.jpg', NULL, 0, '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `product_images` VALUES (120, '4b8f429b-b5ea-435e-b6d7-e5a111a60f65', 24, 'products/images/g6j1tzfXk5LoBhpLeIIWtAZYuharrmCrPznkgWW6.jpg', NULL, 0, '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `product_images` VALUES (121, 'db2e767b-2864-46b4-8dfb-d7e037c37bf4', 24, 'products/images/qSHAQHeibKdnkkjxZAOl0QZI4VIiGiErbjz81uxI.jpg', NULL, 1, '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `product_images` VALUES (122, '9cd5a2d8-db8d-4dbb-a530-c365d0cea54c', 25, 'products/images/9n9HlaxAcIFrMiV8MOkEYc3fb5uY7S1soaj3cqxY.jpg', NULL, 1, '2026-01-25 15:09:16', '2026-01-25 15:09:16');

INSERT INTO `product_images` VALUES (123, 'ee6dab0f-07bf-4775-ba1a-6c1044c2d6bb', 25, 'products/images/ZZgqqCgB36tNDpMv31izt8XEsrvUwwomqNz44ni2.jpg', NULL, 0, '2026-01-25 15:09:16', '2026-01-25 15:09:16');

INSERT INTO `product_images` VALUES (124, '78df2319-fb7a-4076-a12e-790338ecfb1c', 25, 'products/images/rQa3yQYQNBPBZxBezy2KRQXwIuzTFOc4EZ32jgR9.jpg', NULL, 0, '2026-01-25 15:09:16', '2026-01-25 15:09:16');

INSERT INTO `product_images` VALUES (125, '4fa61e77-2357-41be-a39b-05b855acdd89', 25, 'products/images/YMm5iTPCRsdTKz8PG4OR2PyHWCNNI3871khDJUxX.jpg', NULL, 0, '2026-01-25 15:09:16', '2026-01-25 15:09:16');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;

CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` decimal(12, 2) NOT NULL,
  `stock` int NOT NULL,
  `weight` int NULL DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `products_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `products_store_id_foreign`(`store_id` ASC) USING BTREE,
  INDEX `products_category_id_foreign`(`category_id` ASC) USING BTREE,
  INDEX `products_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (6, '0282b178-20a7-4542-8dc7-74d0568977c2', 1, 7, 9, 'products/videos/Cc2R4hUupSSyMDTW0zvZrUnOXmM5OaCtFGd0AEv8.mp4', 'Meja Belajar', 'meja-belajar', 'Pastikan sebelum order, Anda sudah membaca catatan toko.\r\nSelamat Berbelanja!\r\n* PRODUK DIRAKIT SENDIRI OLEH CUSTOMER\r\n* Wajib membuat video unboxing untuk klaim garansi pengiriman\r\n\r\nFitur:\r\n- Desain modern mudah dibersihkan dan mudah dipasang.\r\n- Bahan berkualitas tinggi untuk kekokohan dan stabilitas yang lebih baik.\r\n- Meja serbaguna, bisa digunakan sebagai meja komputer, meja belajar, meja makan, dan sebagainya.\r\n- Meja ini memiliki ruang penyimpanan yang lebih dari cukup untuk berbagai macam buku, alat tulis, barang dekoratif, dll.\r\n\r\nSpesifikasi:\r\n- Ukuran: 120*60*74cm\r\n- Berat: 15.15KG\r\n- Bahan: MDF+Rangka besi\r\n- Ketebalan dinding rangka baja: 0.5mm\r\n- Ketebalan papan kayu: 1.2cm\r\n- Ukuran Rangka besi: 3*1.5cm\r\n\r\nSyarat dan Ketentuan Garansi Pengiriman\r\n1) Wajib membuat VIDEO UNBOXING tanpa jeda.\r\n2) Video unboxing wajib memperlihatkan label resi pesanan, kemasan packing luar, dan komponen produk secara lengkap.\r\n3) Diimbau untuk cek kesesuaian jenis produk dan warna barang yang datang dengan pesanan. Bila tidak sesuai, dilarang merakit produk dan segera chat kami.\r\n4) Jika produk yang diterima rusak dan/atau kurang komponen, harap segera chat kami dengan melampirkan video unboxing.\r\n5) Komplain dan pengembalian setelah memberikan review tidak dapat diproses.\r\n6) Barang yang sudah dirakit TIDAK DAPAT DITUKAR.\r\n7) Menerima komplain maksimal H+5 hari terhitung dari saat barang diterima.\r\n\r\nPacking dan Perakitan\r\n- Packing barang dalam keadaan FLATPACK/BELUM DIRAKIT.\r\n- Dilengkapi petunjuk instalasi di dalam kemasan produk\r\n- Beberapa produk telah disediakan video tutorial perakitan. Untuk lebih detail, dapat ditanyakan melalui chat.\r\n\r\n#MejaKerja #MejaBelajar #MejaKomputer #Meja #MejaBelajarMinimalis#mejaBelajarKayu #mejaBelajarAnak #Kerja', 525000.00, 700, 900, 'active', '2026-01-25 14:23:30', '2026-01-25 15:10:11');

INSERT INTO `products` VALUES (7, '674472cd-ce6b-498e-83a1-b84531c85404', 1, 7, 9, 'products/videos/QyGIqIwwahcopkZnsIkn7liHgQTDUk1KSl5N9g3e.mp4', 'Kursi Belajar', 'kursi-belajar', 'Detail produk dari BG SPORT OFFICE CHAIR MODEL B - KURSI KANTOR MURAH\r\n\r\nKursi yang cocok untuk berkerja, belajar dengan design modern, elegan, dan nyaman serts sandaran Mesh/Jaring Polyster yang menjaga sirkulasi udara agar tetap sejuk pada bagian punggung sehingga tetap nyaman meski diduduki dalam waktu yang lama.\r\nSandaran\r\nJaring untuk ventilasi yang baik Bahannya ramah, tahan lama,tidak mudah pecah.\r\nSandaran\r\nDukungan ke tulang , Tulang belakang dan kurangi gejala , Kelelahan itu bagus\r\nBantal\r\nJala lembut dan nyaman , Bisa mendinginkan panas dengan baik , Tidak kehilangan bentuknya\r\nSandaran lengan\r\nDikontur ke tubuh , Cantik dan tahan lama\r\nMaterial\r\nTerbuat dari bahanKualitas baik Kuat dan tahan lama Dan aman\r\nKURSI KANTOR\r\nmembuatmu lebih nyaman Sandaran dirancang untuk menyediakan Dukungan yang baik untuk tulang belakang.\r\n\r\n𝗔𝗳𝘁𝗲𝗿 𝗦𝗲𝗹𝗹 𝗦𝗲𝗿𝘃𝗶𝗰𝗲\r\n- Silahkan hubungi admin kami terlebih dahulu, apabila ada kendala terhadap produk sebelum memberi ulasan.\r\n- Jika ada keluhan terhadap produk, WAJIB di sertakan video unboxing, jika tidak ada video unboxing mohon maaf kami tidak menerima keluhan tersebut.\r\n- Jika pemesanan sebelum jam 14.00 WIB, pesanan akan kami proses dihari yang sama.\r\n- Jika pemesanan setelah jam 14.00 WIB, pesanan akan kami proses di esok hari nya.\r\n- Untuk pengiriman akan kami kirimkan sekitar 1-2 hari kerja jika menggunakan jasa ekspedisi\r\n- Untuk pengiriman menggunakan Jasa Kirim Instan, pesanan akan kami kirimkan maksimal jam 16.00 WIB', 199000.00, 500, 1100, 'active', '2026-01-25 14:28:47', '2026-01-25 15:10:17');

INSERT INTO `products` VALUES (8, '89d51e76-e0b5-43e5-a83b-483293cacd1e', 1, 7, 9, NULL, 'Rak Buku', 'rak-buku', 'BM Rak Buku Minimalis Kayu Serbaguna✨ Warna: Putih + Warna Kayu\r\n✨ Material: WOOD\r\n✨ Fungsi: Rak susun kayu serbaguna, penyimpanan praktis, rak sepatu, rak baju bayi newborn, rak kosmetik, rak susun 4 tingkat, rak aesthetic kamar, rak sepatu tertutup.\r\nSpesifikasi Produk\r\nPeriksa alamat dan ukuran: Sebelum pemesanan, periksa alamat dan ukuran produk dengan teliti.\r\nPesan rusak: Jika produk rusak atau komponennya hilang, chat kami dengan video unboxing. Kami akan memberikan layanan terbaik.\r\nLayanan Pelanggan\r\nUlasan bintang lima + foto: Hubungi layanan pelanggan untuk kejutan!\r\nPengiriman: Pengiriman dalam 24 jam.\r\nDiskon 50%: Dapatkan promo Guncana 7.7.\r\nCOD: Tersedia opsi COD.', 148000.00, 83, 1600, 'inactive', '2026-01-25 14:31:46', '2026-01-25 14:31:46');

INSERT INTO `products` VALUES (9, '5f963eb6-4d32-421a-b47b-c0b87f95ac12', 1, 7, 9, 'products/videos/rh3HCkOrQvHLbiGHA8meFmswPmyFXxK3VwObEJZ8.mp4', 'Lemari Arsip', 'lemari-arsip', 'HARGA TERBAIK DAN BERKUALITAS TINGGI\r\n\r\nMau belanja Aman ? Harus Official Store ya !\r\n\r\nQ : Kenapa Anda Harus Belanja di Citra Furniture ?\r\n\r\nA : Karena kami adalah Importir langsung tanpa Perantara sehingga bisa memberikan Harga dan kualitas terbaik untuk anda\r\n\r\nQ : Apakah bisa menerbitkan faktur pajak?\r\n\r\nA : Perusahaan kami sudah PKP dan memiliki Legalitas hukum jadi bisa bisa menerbitkan Faktur Pajak\r\n\r\nHUBUNGI KAMI JIKA ADA YANG LEBIH MURAH DARI KAMI : )\r\n\r\n\"Citra Furniture siap menjadi Mitra terbaik Anda \"\r\n\r\n[ Harga sudah termasuk PPN)\r\n\r\n#lemariarsip #lemariarsipbesi #lemariarsipdokumen #lemaribesi #lemaribesiarsip #filingcabinet #fillingcabinet #kabinetbesi #cabinetkantor #lemarikantor #lemaribesikantor\r\n\r\n\r\nukuran type pendek\r\n P.85 X L.40 X T.85\r\n\r\nukuran type tinggi\r\nP.85 X L.40 X T.180\r\n\r\nTingkatkan produktivitas Anda dengan lemari arsip dari Citra Furniture! Dengan dokumen yang terorganisir dengan baik, Anda dapat menemukan dokumen yang Anda butuhkan dengan cepat dan mudah. Desainnya yang modern dan kokoh, lemari arsip ini dapat menampung berbagai jenis dokumen.\r\n\r\nPengiriman Barang Menggunakan Mobil Pickup toko\r\nProses pengiriman estimasi 2 - 4 hari\r\nbiaya sesuai aplikasi', 1375000.00, 896, 100, 'active', '2026-01-25 14:33:32', '2026-01-25 15:10:28');

INSERT INTO `products` VALUES (10, 'c3b7440f-1cbc-4118-bc07-5474583f69d8', 1, 7, 9, NULL, 'Papan Tulis', 'papan-tulis', 'Deskripsi Papan Tulis 30 x 50 cm Whiteboard\r\npapan Tulis Tempel 30 x 50 cm Non Magnet\r\nList Alumunium Warna Hitam Tebal 9 mm\r\nSudut Bahan Plastik Berkwalitas\r\nPapan Depan Putih glossy ( Whiteboard ) Buat Spidol\r\nTampak Belakang Black Board\r\n2 Fungsi Bolak Balik\r\n2 Ring Buat Gantungan', 39900.00, 9, 200, 'inactive', '2026-01-25 14:35:41', '2026-01-25 14:35:41');

INSERT INTO `products` VALUES (11, 'da565faa-2bb6-4411-a534-6f3e323318ab', 1, 7, 10, 'products/videos/lDJewXMDLtOxPZnbe0JeXV9eylRHYmihyWE3d6YD.mp4', 'Tempat Tidur Single', 'tempat-tidur-single', 'ONNO MALL- Ranjang Lipat Besi Tempat Tidur Lipat Portable Sofa BedSelamat datang di toko furnitur ONNO\r\n semua produk adalah penjualan langsung ke pabrik, 100% asli\r\nSpot pengiriman barang dengan cepat, dikirim dalam 24 jam ke tangan anda selama 3-5 hari\r\nSelamat datang di toko, dibeli dan dijual oleh para bos grosir\r\nJika anda memiliki pertanyaan lebih lanjut, silakan hubungi layanan pelanggan anda segera, jangan tinggalkan komentar negatif.\r\nJam kerja 8:00 sampai 24:00. 🌟\r\nFitur Ranjang Lipat\r\nDesain lipat, hemat energi dan ruang!\r\nBahan lembut dan nyaman, ramah di kulit.\r\nKuat dan stabil, rangka tebal, menahan beban 500KG.\r\nSolusi untuk AndaIstirahat makan siang kantor, makan malam keluarga, atau piknik di luar. Tidak ada tempat tidur yang nyaman. Gaya: tabung persegi berwarna hitam. Ukuran: 190cm*75cm40cm, 190cm*100cm40cm, 190cm*120cm*40cm.\r\nCatatan Penting\r\nPeriksa alamat pengiriman dan ukuran produk sebelum pemesanan.\r\nJika produk rusak, chat kami dengan video unboxing.\r\nKomplain dan pengembalian setelah review tidak dapat diproses.\r\nJangan beri ulasan negatif tanpa pertukaran.', 499000.00, 206, 22000, 'active', '2026-01-25 14:37:59', '2026-01-25 15:10:48');

INSERT INTO `products` VALUES (12, '76729d8b-bc0d-497b-b784-c7aca65082ea', 1, 7, 10, 'products/videos/oOvSE4KlTB2RGbmgcLSCnHq09lTZ3SFPTT5YMKYj.mp4', 'Lemari Pakaian', 'lemari-pakaian', '› Harap untuk membaca deskripsi produk sampai selesai.\r\n› Chat kami terlebih dahulu untuk memastikan daerahmu masuk area jangkauan kurir kami.\r\n\r\nSimpan pakaian kesayanganmu di dalam lemari pakaian LUNA LPM 301 yang dilengkapi dengan rak, meja dan satu buah cermin cantik yang dapat dibuka. Lemari ini mampu menjaga pakaianmu agar tetap aman dari debu dan serangga.\r\n-\r\nLUNA LPM 301 ini dapat berfungsi sebagai lemari penyimpanan beragam perlengkapan rumah kamu. Lemari pakaian ini mempunyai desain minimalis sangat pas untuk memperindah kamarmu.\r\n\r\nMerk: Cubic\r\nBahan: Papan partikel export quality dengan finishing sheet premium\r\nVariasi Warna & Motif:\r\n- Sonoma Black-Grey\r\n- Sonoma Oak-White\r\n\r\nDimensi Produk (MM): 1194 X 415 X 1843\r\nDimensi Packing (MM): 1831 X 470 X 150\r\nBerat Total: 63,5 Kg\r\n\r\nKelebihan:\r\n- Kuat dan kokoh\r\n- Sliding mulus\r\n- Permukaan luas dan halus\r\n- Menggunakan edging\r\n- Desain elegan & minimalis\r\n- Particle board dengan bahan premium (Kualitas Terbaik)\r\n- Buku perakitan yang mudah dimengerti\r\n- Dibuat menggunakan mesin modern dari Jerman\r\n\r\n--------------- INFORMASI PENTING ---------------\r\n\r\nSyarat dan Ketentuan Garansi Pengiriman\r\n- Dihimbau untuk cek kesesuaian jenis produk dan warna barang yang datang dengan pesanan. Bila tidak sesuai segera chat kami.\r\n- Jika produk yang diterima rusak dan/atau kurang komponen, harap segera chat kami.\r\n- Pengajuan komplain dan pengembalian mohon segera chat kami.\r\n- Silakan hubungi kami terlebih dahulu jika ada kendala sebelum memberikan bintang atau penilaian\r\n\r\nPacking dan Perakitan\r\n- Packing barang dibuat seminimal mungkin untuk mengurangi potensi kerusakan selama pengiriman dan beberapa kurir memiliki batas maksimal dimensi, sehingga barang masih dalam keadaan flatpack atau belum dirakit.\r\n- Untuk buku petunjuk instalasi / assembly instruction book sudah ada di dalam packing produk.\r\n- Beberapa produk telah disediakan video tutorial perakitan. Untuk lebih detail, dapat ditanyakan melalui chat.\r\n- Kami melayani jasa instalasi dengan biaya tambahan khusus wilayah Surabaya, Sidoarjo, Gresik dan Jadetabek.\r\n\r\nWilayah Gratis Ongkir\r\nHarap untuk KONTAK KAMI melalui chat. Untuk memastikan daerahmu masuk area jangkauan kurir kami. Kententuan Gratis Ongkos Kirim:\r\n- Daerah Pulau Jawa dan Bali KECUALI Karimun Jawa, Nusa Penida, dan Kepulauan Seribu, dan Beberapa daerah yang cabang ekspedisi tutup akan diantar sesuai alamat.\r\n- Daerah Karimun Jawa, Nusa Penida, dan Kepulauan Seribu, dan Beberapa daerah yang cabang ekspedisi tutup dapat mengambil paket di kantor droppoint terdekat\r\n- Daerah di luar Pulau Jawa dan Bali, harap hubungi kami karena berpotensi mendapatkan gratis ongkos kirim\r\n- Area jangkauan ekspedisi/kurir dapat tutup sewaktu-waktu. Untuk lebih memastikan dapat gratis ongkir disarankan menghubungi kami terlebih dahulu\r\n\r\nPengiriman Gratis Ongkir\r\n- Estimasi pengiriman gratis ongkir 3-7 hari kerja, jika lebih dari 7 hari kerja sejak pengiriman harap chat kami.\r\n- Demi kelancaran proses pengiriman, harap memastikan nomor kontak yg tertera adalah nomor yang selalu aktif dan bisa dihubungi.\r\n- Pengiriman dilakukan pada hari kerja (Senin - Jumat)\r\n- Jika konfirmasi pembelian sebelum pukul 09.00 WIB (Jumat maks 11.00 WIB), akan dikirim di hari yang sama. Selebihnya akan dikirim keesokan harinya (hari kerja dan tidak termasuk hari libur)\r\n\r\nCustomer Service\r\n› Layanan Customer Service oleh Activ Furniture (Senin-Jumat 07.30 - 16.30 Hari Kerja)\r\nSelamat Berbelanja!', 1049000.00, 348, 63500, 'inactive', '2026-01-25 14:40:57', '2026-01-25 14:40:57');

INSERT INTO `products` VALUES (13, '74487725-4f75-4bb2-8d01-53fbb599c27a', 1, 7, 10, NULL, 'Meja Lipat', 'meja-lipat', 'MEJA SERBAGUNA OUTDOOR LIPAT KOPER\r\n\r\nDeskripsi Produk\r\n1.Sangat Cocok untuk kegiatan outdoor\r\n2.Cocok untuk alat piknik Bersama Keluarga\r\n3.Cocok untuk meja tambahan keluarga\r\n4.Rangka Terbuat Dari Alumunium\r\n5.Papan Terbuat Dari HPL (High Pressure Laminate)\r\n6.Ukuran dilipat Koper 62 x 10 x 63 cm\r\n7.Ukuran meja 120 x 60\r\n8.Ketinggian meja dapat di atur', 245900.00, 20, 5000, 'active', '2026-01-25 14:42:22', '2026-01-25 15:10:41');

INSERT INTO `products` VALUES (14, 'e5c72bc8-1ac2-42eb-ab23-b5d0674850b0', 1, 7, 10, NULL, 'Rak Sepatu', 'rak-sepatu', 'Rak Sepatu 4 Tingkat Bahan Plastik Shoe Rack Tempat Sandal Bongkar Pasang Portable\r\n \r\nDeskripsi Produk :\r\n- Tersedia warna hitam\r\n- Bahan plastik\r\n- Cocok digunakan untuk tempat sepatu dan sandal\r\n- Bisa digunakan untuk rak lainnya\r\n- Mudah di bongkar pasang\r\n- Lebih hemat tempat\r\n- Size 52 x 19 x 60 cm\r\n- Berat 1000 gram\r\n \r\nNote :\r\nProduk bisa dibeli = Ready stock\r\nDikirim sesuai varian yang diorder (tidak menerima perubahan via chat / catatan)\r\nRANDOM = Dikirim sesuai dengan stok gudang\r\n3x Pengecekan sebelum dikirim, pasti terjamin dan berfungsi dengan baik\r\nProduk rusak / pecah dalam proses pengiriman dapat diklaim ke pihak ekspedisi\r\nWAJIB menyertakan foto resi fisik, foto produk yang diterima, dan video UNBOXING (dari paket tersegel) untuk pengajuan komplain\r\n \r\n#rak #raksepatu #shoerack #raksandal #raksepatuplastik #rakportable', 36900.00, 469, 1000, 'inactive', '2026-01-25 14:43:56', '2026-01-25 14:43:56');

INSERT INTO `products` VALUES (15, '2a31e4e8-5b83-4241-83c2-215836e796c9', 1, 7, 10, 'products/videos/10Qoiy4o2DXy8izz1iivHWB2saURUvYbaEScsYeA.mp4', 'Meja Rias', 'meja-rias', '【Fitur】\r\n-Desain struktur yang sederhana dan individual，Meja lebar\r\n-Mudah dirakit, tidak merepotkan, dan harga terjangkau!\r\n-Cermin berbentuk bulat, permukaan cermin jernih, dan lampu LED bersifat opsional.\r\n-Permukaan meja rias memiliki lapisan cat ramah lingkungan, yang sangat mewah dan unggul, dan permukaan yang halus membuat meja lebih canggih.\r\n-Laci tertutup + rak terbuka membuat desktop lebih rapi dan dapat digunakan untuk menyimpan barang-barang kecil seperti kosmetik.\r\n【Spesifikasi】\r\nBahan: Papan Serat Kepadatan Sedang (MDF)\r\nUkuran: 80 * 40 * 128 cm\r\nPaket: Meja rias (papan, paket sekrup, petunjuk pemasangan) tidak termasuk kursi\r\n【Informasi Instalasi】\r\n- Produk dikirim dalam kondisi BELUM DIRAKIT. Perakitan dilakukan sendiri oleh customer.\r\n- Untuk buku petunjuk instalasi / assembly instruction book sudah ada di dalam packing produk.\r\n- Beberapa produk telah disediakan video tutorial perakitan. Untuk lebih detail, dapat ditanyakan melalui.\r\n【Tip】\r\n- Semua produk yang dijual berada di gudang lokal dan akan dikirim dalam waktu 48 jam setelah pesanan dikonfirmasi.\r\n- Semua produk baru dan akan diperiksa untuk Anda sebelum pengiriman!\r\n- Paking yang tebal dan aman agar paket tidak rusak pada saat pengiriman!', 569000.00, 83, 20500, 'active', '2026-01-25 14:45:30', '2026-01-25 15:11:03');

INSERT INTO `products` VALUES (16, '4aae55e3-bee0-4efc-8501-8ecf93817755', 1, 7, 11, NULL, 'Kipas Angin', 'kipas-angin', 'Desk Fan Kipas Angin Meja 9 Inch Mitsuyama MS-5544\r\n\r\nSpesifikasi :\r\n• Tipe : MS-5544\r\n• Seri : Desk Fan\r\n• Kecepatan Kipas : 2 Kecepatan\r\n• Daya Keluaran : Speed 1 = 20 Watt\r\nSpeed 2 = 24 Watt\r\n• Sumber Daya : AC 220 V\r\n• Dimensi : 23 X 23 X 36 cm\r\n\r\nKipas ini memiliki model yang sangat elegan dan kuat membuat kipas ini banyak diminati orang. Dengan kecepatan angin yang sangat kencang dan tidak berisik serta menghasilkan hembusan angin yang lembut membawa suasana kesejukan dan tidak gerah. Sangat cocok digunakan pada ruangan seperti di kamar, ruang tamu dan lain-lain. Kipas bisa diatur kecepatannya dengan memutar knob di bagian belakang kipas. Bahan buatan yang sangat halus, kokoh dan mudah dibersihkan. Tahan lama dan mutu terjamin.\r\n\r\nKelebihan :\r\n• Motor Handal dan Kuat\r\n• Suara Kipas Halus\r\n• Angin Kencang\r\n• Bisa berputar 180 derajat', 89000.00, 50, 1300, 'active', '2026-01-25 14:46:33', '2026-01-25 15:10:54');

INSERT INTO `products` VALUES (17, 'ddac00d7-31aa-469d-a509-6cdede3e9a2e', 1, 7, 11, NULL, 'Dispenser', 'dispenser', 'UNTUK PENGIRIMAN LUAR MAKASSAR, BERAT YANG DI HITUNG DALAM PENGIRIMAN BERDASARKAN DIMENSI PACKINGAN PAKET ATAU VOLUMETRIK PACKINGAN.\r\n\r\nMOHON UNTUK SERTAKAN BUBBLE WRAP SAAT TRANSAKSI AGAR PRODUK LEBIH AMAN\r\nUNTUK PENGIRIMAN KELUAR KOTA , MOHON TAMBAHKAN PACKINGAN KAYU\r\n( BIAYA PACKINGAN KAYU DILUAR HITUNGAN BERAT BARANG YANG TERLAMPIR )\r\n\r\nSpesifikasi :\r\nWarna : Random\r\nBahan Material Luar : Plastik\r\nBahan Material Tangki : Stainless Steel\r\nJumlah Kran : 2 Kran\r\nDaya Listrik : 320 Watt\r\nTegangan : 220-240 Volt / 50 Hz\r\nIndicator LED : Ya\r\nDimensi : 31 cm x 31.5 cm x 46 cm\r\nBerat : 4 Kg', 277200.00, 5, 4000, 'inactive', '2026-01-25 14:54:22', '2026-01-25 14:54:22');

INSERT INTO `products` VALUES (18, '47d60a3e-6706-499c-8843-0192d8b26afc', 1, 7, 11, NULL, 'Rice Cooker', 'rice-cooker', 'Terbukti sampai 2 hari Nasi No Basah No Basi - 400W penanak nasi, rice cooker digital, rice cooker digital philips, digital rice cooker\r\n\r\nDibuktikan langsung oleh ribuan orang di Pekan Raya Jakarta 2025\r\nMasak Nasi Serentak Ratusan Rice Cooker 2 hari Nonstop\r\nHasilnya benar benar No basah No basi dan Mencetak Rekor Muri!\r\n\r\n\r\nDengan versi terbaru FreshDefense Technology 2.0 , dan perlindungan Anti bakteri.\r\nMemastikan suhu didalam rice cooker tetap stabil dan pastikan udara dalam rice cooker tetap bersih sehingga mencegah bakteri penyebab basi\r\n\r\nNo Basah No Basi, Hanya Philips dengan FreshDefense Technology 2.0 dan Perlindungan Anti bakteri\r\n\r\nMasak apapun Tinggal Cemplung jadi cepet no ribet. Dengan 16 preset menu dari kukus, nasi claypot, hingga kue\r\n\r\nDesain pot berbentuk bulat sempurna, sehingga distribusi panas 2X lebih optimal untuk nasi matang merata di setiap sisi anti kering dan berkerak.\r\n\r\nNasi Matang merata tanpa sisa, dengan Innerpot Spherical 60◦\r\nDesain pot berbentuk bulat sempurna, sehingga distribusi panas 2X lebih optimal untuk nasi matang merata di setiap sisi anti kering dan berkerak.\r\n\r\nNasi pulen dan matang merata - Sistem Smart 3D Heating, pemanasan di segala arah\r\n\r\nInnerpot Anti lengket 6X lebih Kuat dan lebih Awet - 5 Lapisan Alumunium dengan tebal 2 mm, memastikan innerpot yang anti lengket, anti gores, anti baret, lebih kuat, awet, dan tahan lama\r\n\r\nDilapisi dengan lapisan diamond powder untuk lapisan anti lengket dan anti gores yang lebih awet\r\n\r\nPASTI PAS – Dengan kapasitas 1.8 L cocokuntuk 10-14 porsi\r\n\r\nPASTI AWET - Kualitas Eropa terjamin awetnya – Jika rusak, klaim garansi resmi 2 tahun di seluruh dunia.\r\n\r\nBarang-barang yang anda dapatkan di dalam kotak:\r\n- 1 x Rice Cooker\r\n- 1 x Kartu Garansi – Pastikan Anda menyimpan kartu garansi\r\n- Gelas ukur\r\n- Sendok nasi\r\n- Keranjang kukus', 971400.00, 367, 8300, 'inactive', '2026-01-25 14:56:21', '2026-01-25 14:56:21');

INSERT INTO `products` VALUES (19, '585bb876-0c92-42e7-b986-14a821120d14', 1, 7, 11, NULL, 'Setrika', 'setrika', 'MIYAKO Setrika Listrik EI-2000B Adalah Setrika Listrik Yang Cocok Digunakan Di Rumah. Dengan Tegangan Masuk 220V & Daya Konsumsi Sebesar 395W, Setrika Ini Mudah Digunakan & Membantu Anda Menyetrika Pakaian Dengan Cepat & Mudah.\r\nMIYAKO Setirka Listrik EI-2000B Hadir Dengan Garansi Resmi Selama 12 Bulan. Dengan Kondisi Produk Yang Baru, Anda Dapat Yakin Akan Kualitas Produk Ini. Dalam Penggunaannya, MIYAKO Serika Listrik EI-2000B Memberikan Kemudahan & Kenyamanan Dalam Menyetrikan Pakaian Di Rumah Anda.\r\nSpesifikasi :\r\n\r\n- Daya : 395 Watt\r\n\r\n- Anti Lengket\r\n\r\n- Tegangan : 220V\r\n\r\n- Pengatur Suhu Yang Mudah Di Gunakan\r\n\r\n- Lapisan Alumunium Pada Bagian Dalam\r\n\r\n- Lebih Aman Dengan Kabel Ground\r\n\r\n- Pengaturan Suhu Otomatis\r\n\r\n- Garansi Resmi Miyako 1 Tahun\r\n\r\nUkuran Kemasan :\r\n\r\n- Panjang : 25.3 cm\r\n\r\n- Lebar : 10.8 cm\r\n\r\n- Tinggi : 11.7 cm\r\n\r\n- Berat : 800 gr', 120200.00, 23, 1000, 'active', '2026-01-25 14:57:48', '2026-01-25 15:10:36');

INSERT INTO `products` VALUES (20, '7e2b9ec4-12ca-4680-86e0-a4bc773d98fe', 1, 7, 11, NULL, 'Lampu Meja', 'lampu-meja', 'Lampu Meja Belajar LED Eye Protection TaffLED T302 Kabel USB 8 Watt 3 Warna CNS\r\n\r\nWARNA PUTIH\r\n\r\nKurangnya pencahayaan yang layak akan mengganggu konsentrasi saat membaca atau bekerja. Sebagai solusinya, Anda dapat menggunakan lampu meja dari TaffLED! Anda akan merasa nyaman saat membaca dan menulis berkat 3 pilihan warna yang dapat diatur intensitasnya. Selain itu, cahayanya juga tidak berkedip sehingga lebih aman di mata. Anda bahkan bisa melipat lampu menjadi lebih ringkas untuk dibawa atau disimpan.\r\n\r\nTanpa Flicker dan Radiasi\r\nFlicker (kedip) dan radiasi merupakan gangguan yang sering terjadi pada lampu. Dua gangguan tersebut dapat membuat mata tidak nyaman. Namun tenang, lampu meja ini sudah teruji kualitasnya karena memiliki tingkat radiasi yang aman dan minim flicker.\r\n\r\nAtur Temperatur Warna Cahaya\r\nPencahayaan yang dibutuhkan bisa berbeda tergantung kondisi ruangan. Itulah mengapa lampu meja belajar ini dibekali dengan 3 pilihan temperatur warna cahaya. Intensitasnya juga dapat diatur dengan cara menahan tombol power agar mata Anda lebih nyaman ketika menggunakan lampu ini.\r\n\r\nDengan Kabel Daya Micro USB\r\nTidak perlu repot membeli baterai, lampu belajar ini dapat Anda nyalakan hanya dengan sambungan kabel daya. Plug yang digunakan adalah micro USB. Dengan begitu, Anda bisa menghubungkan kabelnya ke berbagai perangkat seperti power bank, laptop, PC dan lainnya.\r\n\r\nFitur Lipat Lebih Ringkas\r\nBerbeda dari lampu meja lainnya, lampu yang satu ini dibekali dengan fitur lipat. Rangkanya dapat dilipat hingga menjadi lebih ringkas. Anda pun bisa menyimpannya atau membawanya untuk dipindahkan dengan mudah.\r\n\r\nRincian yang Anda dapatkan untuk pembelian produk ini:\r\n1 x Lampu Meja Belajar LED Eye Protection TaffLED T302 Kabel USB 8 Watt 3 Warna CNS\r\n1 x Kabel Micro USB\r\n1 x Panduan Penggunaan\r\n\r\nJumlah LED 16\r\nTemperatur Warna Warm White, Natural White, Cool White (3500-6000 K)\r\nVoltase DC 5 V\r\nDaya / Power 8 W\r\nMaterial ABS\r\nDimensi Alas: 9 x 13.5 x 2 cm\r\nLeher: 25.5 cm\r\nLampu: 18 cm\r\nTinggi: 28.5 cm\r\nPanjang Kabel: Sekitar 80 cm\r\nLain-lain Port: Micro USB\r\n\r\nLampu Meja Belajar LED Eye Protection TaffLED T302 Kabel USB 8 Watt 3 Warna CNS\r\n\r\n#LampuLED #LampuMejaBelajar #LampuBaca #LampuMeja', 55000.00, 10, NULL, 'inactive', '2026-01-25 14:59:05', '2026-01-25 14:59:05');

INSERT INTO `products` VALUES (21, '9e1a744c-e81c-4785-b0c6-1053aada41cc', 1, 7, 12, NULL, 'Rak Bambu', 'rak-bambu', 'Sudah datang! 👏👏👏👏Selamat datang untuk berbelanja! 🌿\r\nKami menggunakan bambu alami yang bagus untuk membuat rak sepatu, lemari pakaian, dan lainnya yang cantik dan praktis, membuat rumah Anda terasa hangat dan bergaya. 🏠 Tidak peduli jenis furnitur apa yang Anda inginkan, kami punya semuanya, kami jamin akan memenuhi kebutuhan Anda dan juga bisa membuat hidup Anda lebih ramah lingkungan. 🌍 Memilih LOVELY HOME, artinya Anda memilih gaya hidup yang menjadi teman dengan alam, mari kita bekerja sama untuk menjadikan rumah Anda tempat yang nyaman dan penuh kasih! 🏡\r\n\r\nLemari buku ini memiliki desain yang minimalis dan estetik, cocok untuk melengkapi tampilan ruangan Anda. Dengan bahan kayu yang berkualitas, lemari buku ini memberikan sentuhan alami dan hangat pada ruangan Anda. 🌿🏠\r\nRak buku ini dilengkapi dengan pintu dan panel transparan, sehingga memungkinkan Anda untuk melihat koleksi buku Anda dengan mudah. Hal ini tidak hanya memudahkan dalam mencari buku yang diinginkan, tetapi juga memberikan kesan estetik dan mempercantik tampilan lemari buku Anda. 📚🔍\r\nLemari buku ini tidak hanya cocok untuk ruang tamu atau kantor, tetapi juga dapat ditempatkan di kamar tidur, ruang belajar, atau bahkan ruang kerja. Dengan desain minimalis dan estetiknya, lemari buku ini akan memberikan sentuhan elegan dan teratur pada ruangan tersebut. 💫🏡\r\n📢Tips:\r\n✨Karena tampilan dan efek pencahayaan yang berbeda, warna produk yang sebenarnya mungkin sedikit berbeda dari warna gambar!\r\n✨Sebelum melakukan pemesanan, harap periksa alamat pengiriman, warna, dan ukuran produk Anda dengan saksama. Karena alasan teknis, kami tidak dapat mengubah informasi pesanan untuk Anda.\r\n✨Silakan menghubungi atau mengobrol bantuan jika Anda memiliki pertanyaan tentang produk. Maaf atas ketidaknyamanan yang ditimbulkan.\r\n✨Jika produk yang Anda terima salah, rusak, hilang, dll, silakan hubungi kami. Kami akan melakukan yang terbaik untuk bekerja sama dengan Anda untuk memberi Anda layanan keseimbangan dan penggantian. kami akan mencoba yang terbaik untuk memberikan layanan terbaik.\r\n❤‍- Selamat berbelanja! -❤', 509000.00, 98, 14400, 'active', '2026-01-25 15:02:11', '2026-01-25 15:10:23');

INSERT INTO `products` VALUES (22, 'ffa8ca52-1c1e-4cb7-bd4a-98f66cdb082d', 1, 7, 12, NULL, 'Kursi Rotan', 'kursi-rotan', 'Order yang masuk setelah jam 15.00 akan kami proses pada hari kerja berikutnya.\r\n\r\n\r\nSETIAP PEMBELIAN KURSI MOMON 1 SET GRATIS BANTAL 2 PCS\r\n\r\n\r\nKelengkapan Produk :\r\n- Kursi = 2 pcs\r\n- Meja = 1 pcs\r\n\r\n\r\nMaterial :\r\n- Rotan Kulit = sibalio\r\n- Finishing = Melamin\r\n- Tali iket = Lesio blith\r\n\r\n\r\nUkuran\r\n- P 52cm x L 49cm x T 65cm\r\n- Diameter Dudukan 45cm\r\n- Tinggi Dudukan 33cm\r\n\r\n\r\n\r\n\r\nKursi momon ini sangat cocok untuk bersantai sambil ngopi didepan teras rumah anda. Kursi ini kuat menahan beban hingga ±100kg, jadi jangan khawatir tidak kuat kalo misalkan orang dewasa/orang gemuk menduduki kursi ini, dijamin kuat.', 110000.00, 931, 10000, 'inactive', '2026-01-25 15:03:19', '2026-01-25 15:03:19');

INSERT INTO `products` VALUES (23, '8751cbda-f4f7-4886-8da0-8e127c8a84bf', 1, 7, 12, NULL, 'Meja Kayu Daur Ulang', 'meja-kayu-daur-ulang', '[Harga untuk 1 pcs Daun Meja Top Table Kotak / Bulat, tidak termasuk Kaki Meja]\r\nJika varian bisa diklik, berarti ready stock ya :D\r\nHarap pilih sesuai varian Ukuran, Ketebalan & Warna yang diinginkan\r\n\r\nBentuk Kotak / Bulat dapat dicantumkan di note atau catatan pesanan ketika checkout. Jika tidak ada note pesanan, kita kirimkan bentuk random\r\n\r\nBISA CUSTOM Ukuran / Bentuk / Warna, langsung chat ke admin! :D\r\n\r\nPLASMA Eco-Friendy Home Decor & Furniture\r\nRecycled Plastic Manufacture / Pabrik Daur Ulang Plastik\r\n\r\nDaun Meja Top Table Recycled Plastic\r\nCorak yang estetik menjadi nilai tambah cocok untuk Hotel, Restoran dan Kafe (Horeka) bahkan untuk custom kebutuhan rumah tangga\r\nBerfungsi dengan baik di Indoor & Outdoor, karena top table dari bahan recycled plastic anti air, jamur, anti karat & low maintenance\r\n\r\nFinishing,\r\nKotak : Polish & Rounded 4 sudut\r\nBulat : Polish\r\n\r\nUkuran Kotak (PxL) / Bulat (Diameter), dengan opsi ketebalan 1 / 1.5cm :\r\n\r\n40cm\r\n50cm\r\n60cm\r\n70cm\r\n75cm\r\n100cm\r\n\r\nWARNA:\r\n\r\nPendant\r\nDenim Blue\r\nSky Blue\r\nMidas Gold\r\nLagoon Blue\r\nLumora\r\nDandelion\r\nUntuk pemesanan warna diluar varian (masih dalam katalog Flakes) WAJIB konfirmasi ketersediaan bahan melalui Chat admin :D\r\n\r\nPemesanan dalam jumlah banyak ------- KURIR LEBIH AMAN & MURAH PILIH CARGO (JTR JNE Tracking, J&T Cargo)\r\nBerat & Volume PAKET 1pcs Daun Meja :\r\nA) 40cm 45x45x5cm - 1cm, 4Kg / 1.5cm 5Kg\r\nB) 50cm 55x55x5cm - 1cm, 5Kg / 1.5cm 6.5Kg\r\nC) 60cm 65x65x5cm - 1cm, 6Kg / 1.5cm 8.5Kg\r\nD) 70cm 75x75x5cm - 1cm, 7.5Kg / 1.5cm 10.5Kg\r\nE) 75cm 80x80x5cm - 1cm, 8.5Kg / 1.5cm 12.5Kg\r\nF) 100cm 105x105x5cm - 1cm, 13Kg / 1.5cm 18.5Kg\r\n\r\nPromo Buy More Save More [Otomatis saat Checkout] :\r\nBeli 2pcs Disc 2%\r\nBeli 3pcs Disc 3%\r\nPembelian dalam satu invoice minimal 5juta, bisa menggunakan voucher disc Toko sebesar 8%\r\n\r\n# Include Packing menggunakan Kardus dan Palet Kayu\r\n\r\nMesin kami mampu memproduksi Recycled Plastic Sheet / Lembaran ukuran 100x220cm (1x2.2 meter), dengan ketebalan 1 / 1.5 / 2cm.\r\nBisa custom berbagai bentuk & design untuk Kursi, Meja, Rak, Lemari dan masih banyak furniture lainnya.. [Harga B2B bisa ditanyakan ke Admin]\r\n\r\nHasil proses daur ulang plastik, dalam segi motif, warna, bentuk tidak selalu sama sempurna. Foto / video produk hanyalah contoh. Produk sudah melalui QC sebelum dikirim. Kita tidak melayani komplain mengenai hasil warna / motif yang berbeda sedikit dari foto. Membeli berarti setuju. Selamat belanja! :D\r\n\r\nPlasma Living adalah perusahaan yang bergerak di bidang daur ulang sampah plastik menjadi barang - barang bernilai & Eco-friendly seperti aksesoris, kebutuhan rumah tangga, Home Decor, cafe, restoran, interior terutama perabotan / mebel seperti meja & kursi. Happy Shopping and let\'s make an impact for a better planet together!', 435000.00, 3, 4000, 'active', '2026-01-25 15:05:04', '2026-01-25 15:11:10');

INSERT INTO `products` VALUES (24, '9230cde0-5bf3-4a49-93eb-8931bb7db222', 1, 7, 12, NULL, 'Keranjang Anyaman', 'keranjang-anyaman', '✨ Ideal untuk Hampers dan Parcel ✨\r\n\r\n\r\nKeranjang anyaman bambu dengan model persegi panjang dan gagang kokoh, cocok\r\nuntuk hampers, parcel, atau kemasan produk handmade. Dalam 1 pesanan, Anda\r\nakan mendapatkan 10 pcs keranjang sesuai ukuran pilihan. Isi per pesanan: 10\r\npcs.\r\n\r\n\r\n* * *\r\n\r\n\r\n✅ Ukuran Besar: 25 x 10 x 20 cm\r\n✅ Ukuran Sedang: 20 x 10 x 15 cm\r\n✅ Ukuran Kecil: 11 x 4 x 12 cm\r\n\r\n\r\nPilih ukuran yang sesuai kebutuhan Anda. Keranjang ini ramah lingkungan,\r\nringan, dan kuat.\r\n\r\n\r\n* * *\r\n\r\n\r\nHandmade dari bambu pilihan. Cocok untuk hampers, snack box, souvenir, dan\r\ndekorasi. Bisa digunakan ulang. Simpan di tempat kering dan jemur secara\r\nberkala agar tetap awet.\r\n\r\n\r\n* * *\r\n\r\n\r\nHarap maklum jika terdapat selisih ukuran ±1–2 cm karena proses pembuatan\r\nmasih manual. Ideal untuk penjual hampers, pemilik usaha UMKM, atau acara', 79000.00, 405, 1000, 'inactive', '2026-01-25 15:07:46', '2026-01-25 15:07:46');

INSERT INTO `products` VALUES (25, '46134262-3bfb-4f99-9eeb-495ffff9c3aa', 1, 7, 12, NULL, 'Rak Tanaman', 'rak-tanaman', 'panjang ada 3 macam ukuran\r\npanjang 50cm,80cm,100cm\r\nlebar 15/tatakan total 45cm\r\ntinggi 65cm\r\nsusun 3\r\nbahan besi hollow jadi pasti kuat\r\nseimbang\r\nminimalis\r\ndikirim dalam bentuk knockdown', 250000.00, 100, 7000, 'inactive', '2026-01-25 15:09:16', '2026-01-25 15:09:16');

-- ----------------------------
-- Table structure for refunds
-- ----------------------------
DROP TABLE IF EXISTS `refunds`;

CREATE TABLE `refunds`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `payment_id` bigint UNSIGNED NOT NULL,
  `refund_amount` decimal(12, 2) NOT NULL,
  `refund_status` enum('pending','success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `refunded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `refunds_return_id_foreign`(`return_id` ASC) USING BTREE,
  INDEX `refunds_payment_id_foreign`(`payment_id` ASC) USING BTREE,
  INDEX `refunds_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `refunds_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `refunds_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of refunds
-- ----------------------------

-- ----------------------------
-- Table structure for return_items
-- ----------------------------
DROP TABLE IF EXISTS `return_items`;

CREATE TABLE `return_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `condition` enum('new','used','damaged') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `return_items_return_id_foreign`(`return_id` ASC) USING BTREE,
  INDEX `return_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `return_items_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `return_items_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of return_items
-- ----------------------------

-- ----------------------------
-- Table structure for return_shipments
-- ----------------------------
DROP TABLE IF EXISTS `return_shipments`;

CREATE TABLE `return_shipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_id` bigint UNSIGNED NOT NULL,
  `courier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `return_shipments_return_id_foreign`(`return_id` ASC) USING BTREE,
  INDEX `return_shipments_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `return_shipments_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of return_shipments
-- ----------------------------

-- ----------------------------
-- Table structure for returns
-- ----------------------------
DROP TABLE IF EXISTS `returns`;

CREATE TABLE `returns`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `return_status` enum('requested','approved','rejected','item_sent_back','item_received','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `returns_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `returns_order_item_id_foreign`(`order_item_id` ASC) USING BTREE,
  INDEX `returns_buyer_id_foreign`(`buyer_id` ASC) USING BTREE,
  INDEX `returns_seller_id_foreign`(`seller_id` ASC) USING BTREE,
  INDEX `returns_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `returns_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `returns_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `returns_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of returns
-- ----------------------------

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reviews_order_item_id_foreign`(`order_item_id` ASC) USING BTREE,
  INDEX `reviews_buyer_id_foreign`(`buyer_id` ASC) USING BTREE,
  INDEX `reviews_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `reviews_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reviews
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('pCHSbpIUROUjC439fioix9IsOPEFC0ot5iu4C2s8', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieG1mdEFaVXluWnc3UjBqM2RMYlVjZGJqNTJXRWN5dDFzdEJNQjNObiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1769674668);

-- ----------------------------
-- Table structure for shipments
-- ----------------------------
DROP TABLE IF EXISTS `shipments`;

CREATE TABLE `shipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `courier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shipping_status` enum('pending','shipped','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shipments_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `shipments_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipments
-- ----------------------------
INSERT INTO `shipments` VALUES (2, 'df309fa2-68ca-4f2a-8066-57b6cfecb073', 5, 'belum dipilih', NULL, 'pending', NULL, NULL, NULL, NULL);

INSERT INTO `shipments` VALUES (3, '1ca3507a-de08-4e9e-bcd5-12697f3c95c3', 6, 'belum dipilih', NULL, 'pending', NULL, NULL, NULL, NULL);

INSERT INTO `shipments` VALUES (4, '1866e6b7-399b-48da-80fa-9bedc9b0040e', 7, 'belum dipilih', NULL, 'pending', NULL, NULL, NULL, NULL);

INSERT INTO `shipments` VALUES (5, '02e50d7c-5da7-4b9e-a275-3cb790ed05a1', 8, 'belum dipilih', NULL, 'pending', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for stores
-- ----------------------------
DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `store_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `rating` decimal(3, 2) NOT NULL DEFAULT 0.00,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `stores_store_slug_unique`(`store_slug` ASC) USING BTREE,
  INDEX `stores_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `stores_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `stores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stores
-- ----------------------------
INSERT INTO `stores` VALUES (1, '26b7afa3-af83-4b84-8237-83ddfd3c1492', 1, 'CV. TRITUNGGAL EKA PERKASA', 'cv-tritunggal-eka-perkasa', 'CV. TRITUNGGAL EKA PERKASA adalah perusahaan di Kalimantan Timur, khususnya Balikpapan, yang bergerak di bidang konstruksi dan aplikasi produk industri, terkenal sebagai aplikator bersertifikat untuk Hilti Anchor Systems sejak 2004, melayani pemasangan chemical anchor bolt, coring beton, dan jasa konstruksi sumber daya air dengan area kerja di Kalimantan dan Indonesia Timur.', 'Gg. Turi Gg. Damai, Damai, Kecamatan Balikpapan Selatan, Kota Balikpapan, Kalimantan Timur 76114, Indonesia', 0.00, 1, '2026-01-22 14:42:05', '2026-01-22 15:18:04');

INSERT INTO `stores` VALUES (6, '71a8e6a9-b8d9-4a3f-b406-b0d90b146e2f', 1, 'PT. SAMINDO UTAMA KALTIM', 'pt-samindo-utama-kaltim', 'PT Samindo Utama Kaltim was established in 1996. PT Samindo Utama Kaltim offers supporting services for the coal mining activities, i.e. hauling activities. Hauling activities conducted by PT Samindo Utama Kaltim is the transportation of coal from stock pile until the coal port by utilizing two vessel hauling truck. PT Samindo Utama Kaltim is actively transporting the coal owned by PT KIDECO Jaya Agung since 1996.', 'Jl. Tambang, RT 001, Samarangau, Kecamatan Batu Sopang, Kabupaten Paser, Kalimantan Timur', 0.00, 0, '2026-01-22 15:04:22', '2026-01-22 15:04:22');

INSERT INTO `stores` VALUES (7, '9ed84f52-e26b-468b-8a2e-ffddd71a9fcb', 2, 'Eco Store', 'eco-store', 'Eco Store adalah toko yang menyediakan berbagai produk ramah lingkungan dan kebutuhan rumah tangga berkonsep berkelanjutan. Kami menghadirkan perabotan, perlengkapan elektronik, serta kebutuhan fungsional harian yang mengutamakan kualitas, efisiensi, dan kepedulian terhadap lingkungan. Eco Store berkomitmen menjadi pilihan utama bagi pelanggan yang menginginkan produk praktis, modern, dan bertanggung jawab terhadap alam.', 'Jl. Hijau Lestari No. 12, Kelurahan Sukamaju, Kecamatan Setiabudi, Kota Jakarta Selatan, DKI Jakarta 12920', 0.00, 0, '2026-01-25 14:21:50', '2026-01-25 14:21:50');

-- ----------------------------
-- Table structure for user_addresses
-- ----------------------------
DROP TABLE IF EXISTS `user_addresses`;

CREATE TABLE `user_addresses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `recipient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_addresses_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `user_addresses_uuid_index`(`uuid` ASC) USING BTREE,
  CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('buyer','seller','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buyer',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `users_uuid_index`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '359b7c10-26c1-47d8-8c87-cd3a567da824', 'Administrator', 'ecovera123@gmail.com', NULL, '$2y$12$6BKR3pCG/3F69uru300.JOWMI.LiafQ5RwF3i//LkDCUlGUzhhPqu', 'admin', '085213067944', 'profile/1769307950__d15db836-9458-4929-ada6-49a923fff9b2.jpeg', NULL, 1, NULL, '2026-01-25 09:43:43', '2026-01-25 10:25:50');

INSERT INTO `users` VALUES (2, '089f7909-d4d2-403f-9290-6e0372fb6c08', 'Ahmad Fadillah', 'ahmadfadillah502@gmail.com', NULL, '$2y$12$6BKR3pCG/3F69uru300.JOWMI.LiafQ5RwF3i//LkDCUlGUzhhPqu', 'seller', '085213067944', NULL, NULL, 1, NULL, '2026-01-25 09:43:43', '2026-01-25 10:55:25');

INSERT INTO `users` VALUES (3, 'ac348dac-425e-4bdf-befb-cbdacc4ab464', 'Wahyu', 'wahyusyamsuar8@gmail.com', NULL, '$2y$12$teF9623gaOf1iFxPt7g5Nuip0In.B41752OVkeBAEjQXvyeJcoS5O', 'buyer', '085213067944', NULL, NULL, 1, NULL, '2026-01-25 09:43:43', '2026-01-25 09:59:49');

SET FOREIGN_KEY_CHECKS = 1;