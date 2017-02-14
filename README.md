# ansible-project
This is a set of Ansible Playbooks and Roles I use for automation tasks.
Some roles are written from scratch, others taken from ansible-galaxy or other sources.
Role *common* is used for any ansible-managed host.

### Prerequisites for managed hosts
Managed host must be accessible with SSH and have python installed.

Most roles are written for managing hosts running Debian. 
Role *common* also perfectly applies to Ubuntu xenial/yakkety and CentOS-7 hosts.

### Playbooks Description
There are just a few playbooks.

#### site.yml - a universal playbook
It should be able to setup everything on all hosts.
It is usually run with a set of restrictions, either to setup a host, or a service.
Here are some examples:

`ansible-playbook site.yml -l server123` - configure a new server according to groups assigned in inventory.

`ansible-playbook site.yml -t mail -l newsrv` - setup up a new mail server from scratch on new host.

`ansible-playbook site.yml -t bindzone -l ns -e file=example.com` - update DNS zone example.com on DNS master.

#### users.yml - user management playbook.
I concluded that having a separate playbook for user management is the most clear and flexible way to create different users on different hosts with different permissions.
For adding a new user on all hosts you can run: 
```
ansible-playbook users.yml -t vpupkin
```


## How To Start
 * copy ansible.cfg.example into ansible.cfg
 * check group_vars/all to match your needs
 * add your hosts to inventory file. You may want to clean it first from demo content.

Then apply common role to a server, e.g. *testos* using user root to connect
```
ansible-playbook site.yml -t common -l testos -u root
```

Then create users on *testos*
```
ansible-playbook users.yml -l newserver
```

I usually add in .ssh/config entries like
```
Host *.example.com
  Port 8822
  User alitnitskiy
```
Thus the same options from .ssh/config are used whenever I run `ssh ns.example.com` or `ansible -m ping ns`

It is working because I have in *group_vars/all*:
```
domain: example.com
ansible_ssh_host: ansible_ssh_host: "{{inventory_hostname}}.{{domain}}"
```

## Creating a New Project
I use the same set of roles in different projects (I guess it's the primary scope for roles being invented.)

You will probably want to use separate projects when you manage completely different companies. 

Let's suppose it is the *newproject*, then run:
```
rsync  -av ansible-project/ ansible-newproject --exclude roles/ --exclude .git/
```

Then change directory to *ansible-newproject* and create a soft-link: roles -> ../ansible-project/roles

```
ln -ivs ../ansible-project/roles
```

You will probably would like also to use the same site.yml and ansible.cfg in all projects. Then do:
```
ln -ivs ../ansible-project/ansible.cfg
ln -ivs ../ansible-project/site.yml
```
Now you can change the file site.yml inside newproject, and it will effect all projects.

Free advice: keep *ansible-project* in a private repository.

