# LiteSpeed Cache Helper

LiteSpeed Cache Helper is an advanced troubleshooting and companion plugin for the official LiteSpeed Cache for WordPress (LSCWP) plugin. 

## ✨ Features

The plugin features a modern, tabbed UI that organizes tools into easy-to-navigate categories. As we continue to expand the plugin, you will find a growing suite of utilities covering:

* **System Diagnostics:** Built-in tools to verify server environments, check IP routing headers, and test the health of background AJAX requests to ensure your server can communicate properly.
* **QUIC.cloud Troubleshooting:** Quick-action clears to resolve common cloud connection penalties (like domain errors or failed node blocks) and instantly restores communication with QUIC.cloud services.
* **Node & Service Management:** Fine-grained controls to manually assign specific worker nodes for image and page optimization tasks, as well as tools to reset service TTLs.
* **Advanced Utilities & Extras:** A dedicated space for specialized extra features.

## 🚀 Installation

1. Download the latest release `.zip` file from this repository.
2. Log into your WordPress admin dashboard.
3. Navigate to **Plugins** > **Add New** > **Upload Plugin**.
4. Select the `.zip` file and click **Install Now**.
5. Click **Activate Plugin**.

## 💻 Usage

Once activated, navigate to **LiteSpeed Cache** > **LiteSpeed Cache Helper** in your WordPress admin sidebar. 

The dashboard uses a modern tabbed layout. Your active tab is saved locally in your browser, meaning if you perform an action that reloads the page, you won't lose your place.

## ⚠️ Requirements

* **WordPress:** 5.0 or higher
* **PHP:** 7.4 or higher
* **Required Plugin:** [LiteSpeed Cache for WordPress](https://wordpress.org/plugins/litespeed-cache/) must be installed and active for these helper functions to manipulate the LSCWP classes.

## 🛡️ Disclaimer

This is a developer utility. Actions like **Clear All Settings** and manipulating the **Image Optimization post id**, **LiteSpeed meta options** directly alter database states. Always ensure you have a complete database backup before performing resets or fast-forwarding the optimization queues.

## 📝 License

This project is licensed under the GPLv3 License - see the `LICENSE` file for details.
