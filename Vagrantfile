Vagrant.configure(2) do |config|
  config.vm.box = "debian/contrib-jessie64"
  config.vm.network "private_network", ip: "192.168.33.16"
  config.vm.hostname = "itracker.dev"
  config.hostsupdater.aliases = ["itracker.dev"]

  config.vm.synced_folder '.', '/srv/web', create: true,
                          owner: "vagrant",
                          group: "www-data",
                          mount_options: ["dmode=775,fmode=664"]
  config.vm.synced_folder "./vagrant/config/", "/var/config_files", create: true

  config.vm.provision :shell, path: "vagrant/bootstrap.sh"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end
end
