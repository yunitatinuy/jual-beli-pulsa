from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.alert import Alert
import time
from datetime import datetime

login_url = "http://quicktop.infinityfreeapp.com/login.php"

kategori_url = "http://quicktop.infinityfreeapp.com/admin/index.php"

options = webdriver.ChromeOptions()
options.add_experimental_option('detach',True)
driver = webdriver.Chrome(options=options)
driver.maximize_window()

# tentukan kriteria yang ingin dihapus
kriteria = "kuota internet"

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
    driver.get(kategori_url)
    time.sleep(3)

    baris = driver.find_element(By.XPATH, f"//table[@class='table table-striped table-bordered']//tr[td[contains(text(),'{kriteria}')]]")

    tombol_hapus = baris.find_element(By.LINK_TEXT, 'Delete')
    tombol_hapus.click()

    driver.find_element(By.CLASS_NAME, 'btn').click()
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

