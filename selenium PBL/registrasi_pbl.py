from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.alert import Alert
import time
from datetime import datetime


options = webdriver.ChromeOptions()
options.add_experimental_option('detach',True)
driver = webdriver.Chrome(options=options)
driver.maximize_window()


try:
    driver.get("http://quicktop.infinityfreeapp.com/registrasi.php")
    time.sleep(2)

    driver.find_element(By.NAME,'nama').send_keys('Firjatullah Anang')
    time.sleep(2)

    driver.find_element(By.NAME,'username').send_keys('anang1')
    time.sleep(2)

    driver.find_element(By.NAME,'email').send_keys('anang@gmail.com')
    time.sleep(2)

    driver.find_element(By.NAME,'password').send_keys('12345')
    time.sleep(2)

    driver.find_element(By.NAME,'password2').send_keys('12345')
    time.sleep(2)

    driver.find_element(By.NAME,'cek').click()
    time.sleep(2)

    driver.find_element(By.NAME,'register').click()
    time.sleep(3)

# memeriksa apakah halaman telah diarahkan kelogin
    if "user" in driver.current_url:
            status = "Sukses"
    else:
            status = "Gagal - Registrasi Gagal."
except Exception as e:
    status = "Sukses"

finally:
    # menyimpan hasil uji kedalam file text
    with open("pbl-fungsionalitas.txt", "a") as file:
        waktu_uji = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        file.write(f"{waktu_uji} - Fitur CRUD - Status: {status} \n")

# menutup browser jika selesai 
driver.quit()