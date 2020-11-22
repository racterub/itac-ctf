#basics
sudo apt-get update
sudo apt-get -y upgrade
sudo apt-get -y dist-upgrade
sudo apt-get -y autoremove

sudo apt-get install -y curl build-essential cmake python-dev python3-dev python-pip python3-pip git bash-completion




# CTF

sudo chown -R $(whoami) /opt

sudo pip3 install ipython
sudo pip install ipython

sudo apt-get install -y nmap sqlmap strace ltrace
curl -sSL https://raw.githubusercontent.com/rapid7/metasploit-omnibus/master/config/templates/metasploit-framework-wrappers/msfupdate.erb | sudo sh

git clone https://github.com/offensive-security/exploitdb.git /opt/exploitdb
sed 's|path_array+=(.*)|path_array+=("/opt/exploitdb")|g' /opt/exploitdb/.searchsploit_rc > ~/.searchsploit_rc
sudo ln -sf /opt/exploitdb/searchsploit /usr/local/bin/searchsploit

cd /opt
git clone https://github.com/magnumripper/JohnTheRipper
sudo apt-get -y install build-essential libssl-dev git zlib1g-dev yasm libgmp-dev libpcap-dev pkg-config libbz2-dev
cd JohnTheRipper/src
sudo ./configure && sudo make -s clean && sudo make -sj4
