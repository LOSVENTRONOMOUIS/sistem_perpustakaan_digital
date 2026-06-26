import sys
import re

userindex_path = r'c:\laragon\www\sistem_perpustakaan_digital\PBL OOP\views\peminjaman\userindex.php'
katalog_path = r'c:\laragon\www\sistem_perpustakaan_digital\PBL OOP\views\katalog\userindex.php'

with open(userindex_path, 'r', encoding='utf-8') as f:
    u_content = f.read()

with open(katalog_path, 'r', encoding='utf-8') as f:
    k_content = f.read()

css_match = re.search(r'<style>.*?</style>', u_content, re.DOTALL)
if not css_match:
    print('CSS not found')
    sys.exit(1)
css_block = css_match.group(0)

header_match = re.search(r'(<!-- NAVBAR -->.*?<!-- MAIN CONTENT -->)', u_content, re.DOTALL)
if not header_match:
    print('Header not found')
    sys.exit(1)
header_block = header_match.group(1)

# Link adjustments
header_block = header_block.replace('href="peminjaman.php"', 'href="pinjam.php"')
header_block = header_block.replace('class="nav-link-custom active" href="pinjam.php"', 'class="nav-link-custom" href="pinjam.php"')
header_block = header_block.replace('class="nav-link-custom" href="katalog.php"', 'class="nav-link-custom active" href="katalog.php"')
header_block = header_block.replace('href="../views/dashboard/userindex.php"', 'href="dashboard_anggota.php"')
header_block = header_block.replace('$_SESSION[\'nama\']', '$currentUser[\'nama\']')
header_block = header_block.replace('$_SESSION[\'nim\']', '$currentUser[\'email\']')
header_block = header_block.replace('<!-- Toast Container -->\n<div id="toastContainer"></div>\n\n', '')

k_content = re.sub(r'<style>.*?</style>', css_block, k_content, flags=re.DOTALL)
k_content = re.sub(r'<nav class="navbar.*?<div class="content" id="mainContent">', header_block + '<div class="content" id="mainContent">', k_content, flags=re.DOTALL)

with open(katalog_path, 'w', encoding='utf-8') as f:
    f.write(k_content)

print('Successfully updated views/katalog/userindex.php')
