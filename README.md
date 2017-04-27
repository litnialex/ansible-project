# ansible-project
This is a set of [Ansible](http://docs.ansible.com/ansible/index.html) Playbooks and Roles I use for automation tasks.
Some roles are written from scratch (e.g. role *common*), others taken from [ansible-galaxy](https://galaxy.ansible.com/) (like *bind*, *dhcp_server*).

Most roles are written for managing hosts running Debian. 
Role *common* also perfectly applies to Ubuntu xenial/yakkety and CentOS-7 hosts.


## Playbooks Description
There are just a few playbooks.

#### site.yml - a universal playbook
It should be able to setup everything on all hosts.
It is usually run with a set of restrictions, either to setup a host, or a service.
Here are some usage examples:

* `ansible-playbook site.yml -t common -l testos -u root` - run common role for host testos connecting as user root
* `ansible-playbook site.yml -l server123` - configure a new server according to groups assigned to it in inventory.
* `ansible-playbook site.yml -t mail -l newsrv` - setup up a new mail server from scratch on new host.
* `ansible-playbook site.yml -t bindzone -e file=example.com` - update DNS zone example.com on DNS master.

#### users.yml - user management playbook.
I concluded that having a separate playbook for user management is the most clear and flexible way to create different users on different hosts with different permissions.
Usage examples:
`ansible-playbook users.yml -t vpupkin` - for adding a new user on all hosts
`ansible-playbook users.yml -l testos` - setup users on a new host

#### new_guest.yml - create new KVM guest 
    ansible-playbook new_guest.yml -l kvm2 -e 'name=sandbox size=10G ip=192.168.231.18/24 gateway=192.168.231.1 vlan=27'

## How To start
Install dependencies
```python
sudo apt-get install git python-pip libyaml-dev python-dev python-markupsafe
sudo pip install ansible
```

Clone this repository and create ansible.cfg
```bash
git clone https://github.com/litnialex/ansible-project
cd ansible-project
cp ansible.cfg.sample ansible.cfg
```

Review  *ansible.cfg* and make sure that *roles_path* and *inventory* point to actual location.
By default relative paths are used, so you should run `ansible-playbook` and `ansible` commands from root path of this repository.


Remove demo hosts from *example/inventory* and add yours.
Modify *example/group_vars/all* and other files inside *example/group_vars* or *example/host_vars* to match your environment.


## Using multiple inventories
You will probably want to use separate inventories when you manage completely different companies (let's name them projects).
So each project has it's own inventory directory, but they all use the same set of roles.
I guess it's the main purpose of roles being invented.

So all unique and secure data for each project is stored in project's inventory directory.
Check *exmple* directory for a hint.

Crate new inventories for your projets and switch switch between them using *-i* flag, e.g.
```
ansible-playbook -i projectA/inventory ...
ansible-playbook -i projectB/inventory ...
```

Another way is to use environment variable *ANSIBLE_INVENTORY*.
You can run `export ANSIBLE_INVENTORY=./projectA/inventory` and all subsequent commands will use *projectA/inventory*.

Free advice: keep your inventory directories in a private repository.

## SSH Tips and tricks
There is a way to use the same set of ssh options whenever you run `ssh ns.example.com` or `ansible -m ping ns`.
First, add ino *~/.ssh/config* entries like
```
Host *.example.com
  Port 8822
  User alitnitskiy
```

Second part is already done for you, *example/group_vars/all* defines:
```
domain: example.com
ansible_ssh_host: ansible_ssh_host: "{{inventory_hostname}}.{{domain}}"
```


