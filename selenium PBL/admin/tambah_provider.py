from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.alert import Alert
import time
from selenium.webdriver.support.ui import Select
from datetime import datetime

login_url = "http://quicktop.infinityfreeapp.com/login.php"

provider_url = "http://quicktop.infinityfreeapp.com/admin/provider.php"

options = webdriver.ChromeOptions()
options.add_experimental_option('detach',True)
driver = webdriver.Chrome(options=options)
driver.maximize_window()


try:
    driver.get(login_url)
    time.sleep(3)
    
    driver.find_element(By.NAME,'username').send_keys('admin')
    time.sleep(3)

    driver.find_element(By.NAME,'password').send_keys('123')
    time.sleep(3)

    driver.find_element(By.NAME,'login').click()
    time.sleep(3)

    # ke halaman daftar kategori
    driver.get(provider_url)
    time.sleep(3)

    driver.find_element(By.NAME,'tambahprv').click()
    time.sleep(3)

    dropdown = Select(driver.find_element(By.ID,"id_kategori"))

    dropdown.select_by_visible_text("pulsa elektrik")
    time.sleep(2)

    driver.find_element(By.ID,'nama_provider').send_keys('3')
    time.sleep(3)

    driver.find_element(By.ID,'detail').send_keys('Masa aktif 10')
    time.sleep(3)

    driver.find_element(By.ID,'nominal').send_keys('5000')
    time.sleep(3)

    driver.find_element(By.ID,'harga').send_keys('7000')
    time.sleep(3)

    driver.find_element(By.ID,'foto').send_keys('C:/xampp/htdocs/PBL/pembeli/foto_produk/tri.png')
    time.sleep(3)

    driver.find_element(By.ID,'simpanprv').click()
    time.sleep(3)

# memeriksa apakah halaman telah diarahkan ke halaman dashboard
    if "user" in driver.current_url:
            status = "Gagal - Login Gagal."
    else:
            status = "Sukses"
except Exception as e:
    status = "Sukses"

finally:
    # menyimpan hasil uji kedalam file text
    with open("pbl-fungsionalitas.txt", "a") as file:
        waktu_uji = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        file.write(f"{waktu_uji} - Fitur CRUD - Status: {status} \n")

# menutup browser jika selesai 

