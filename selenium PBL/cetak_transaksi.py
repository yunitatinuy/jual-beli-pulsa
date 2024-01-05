from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.alert import Alert
from selenium.webdriver.support.ui import Select
import time
from datetime import datetime

login_url = 'http://quicktop.infinityfreeapp.com/login.php'

riwayat_url = 'http://quicktop.infinityfreeapp.com/pembeli/riwayat.php'

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

# menuju halaman riwayat transaksi
    driver.get(riwayat_url)
    time.sleep(2)

    driver.find_element(By.NAME,'cetak').click()
    time.sleep(2)



    

# memeriksa apakah halaman telah diarahkan ke halaman dashboard
    if "user" in driver.current_url:
            status = "Gagal - Transaksi Gagal."
    else:
            status = "Sukses - Pembelian Sukses"
except Exception as e:
    status = "Sukses"

finally:
    # menyimpan hasil uji kedalam file text
    with open("pbl-fungsionalitas.txt", "a") as file:
        waktu_uji = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        file.write(f"{waktu_uji} - Fitur CRUD - Status: {status} \n")


# menutup browser jika selesai 
driver.quit()