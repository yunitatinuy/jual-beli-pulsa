from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.alert import Alert
import time
from datetime import datetime

login_url = 'http://quicktop.infinityfreeapp.com/login.php'

produk_url = 'http://quicktop.infinityfreeapp.com/pembeli/popup1.php?halaman=detail&id=1'

delete_url= 'http://quicktop.infinityfreeapp.com/pembeli/hapuskeranjang.php?id=1'

options = webdriver.ChromeOptions()
options.add_experimental_option('detach',True)
driver = webdriver.Chrome(options=options)
driver.maximize_window()

try:
    driver.get(login_url)
    time.sleep(2)

    driver.find_element(By.NAME,'username').send_keys('anang1')
    time.sleep(2)

    driver.find_element(By.NAME,'password').send_keys('12345')
    time.sleep(2)

    driver.find_element(By.NAME,'login').click()
    time.sleep(2)

    # membeli keranjang
    driver.get(produk_url)
    time.sleep(2)

    driver.find_element(By.NAME,'beli').click()
    time.sleep(2)

    alert = Alert(driver)
    alert.accept()
    time.sleep(3)

    # menghapus keranjang
    driver.get(delete_url)
    time.sleep(1)

    alert = Alert(driver)
    alert.accept()
    time.sleep(2)

    alert = Alert(driver)
    alert.accept()
    time.sleep(2)

# memeriksa apakah keranjang sudah dikosongkan
    if "user" in driver.current_url:
            status = "Gagal - Gagal hapus produk."
    else:
            status = "Sukses - Tidak ada produk di keranjang"
except Exception as e:
    status = "Sukses"

finally:
    # menyimpan hasil uji kedalam file text
    with open("pbl-fungsionalitas.txt", "a") as file:
        waktu_uji = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        file.write(f"{waktu_uji} - Fitur CRUD - Status: {status} \n")

# menutup browser jika selesai 
driver.quit()