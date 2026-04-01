# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Setup

```bash
cp ansible.cfg.sample ansible.cfg
```

Edit `ansible.cfg` to set `roles_path` and `inventory` to actual paths. By default, run all `ansible-playbook` commands from the repository root.

Galaxy roles (gitignored) go in `/opt/galaxy-roles` or `~/ansible-project/galaxy-roles/`. Project-specific variables and private data are in `vars/` and `private/` (both gitignored).

## Common Commands

```bash
# Run full site config on a host (assigns roles based on inventory groups)
ansible-playbook site.yml -l <hostname>

# Run a specific role/tag on a host
ansible-playbook site.yml -t <tag> -l <hostname>

# Configure base OS (common role)
ansible-playbook site.yml -t common -l <hostname> -u root

# Manage users across all hosts or a specific host
ansible-playbook users.yml
ansible-playbook users.yml -l <hostname>

# Create a new KVM guest
ansible-playbook new_guest.yml -l <kvm_host> -e 'name=<vm> size=10G ip=192.168.x.y/24 gateway=192.168.x.1 vlan=<id>'

# Remove a KVM guest
ansible-playbook remove_guest.yml -e name=<vm>

# Run a single role ad-hoc
ansible-playbook runrole.yml -l <hostname> -e role=<rolename>

# Update a DNS zone
ansible-playbook site.yml -t bindzone -e file=example.com

# Use a specific inventory (for multi-project setups)
ansible-playbook -i projectA/inventory site.yml -l <hostname>
# or
export ANSIBLE_INVENTORY=./projectA/inventory
```

## Architecture

### Multi-Inventory Design
The repo manages infrastructure for multiple independent projects. Each project has its own inventory directory (like `example/`) containing `inventory`, `group_vars/`, `host_vars/`, and `credentials/`. All projects share the same roles in `roles/`. Switch between projects with `-i <project>/inventory` or `ANSIBLE_INVENTORY`.

### Playbook Structure
- **`site.yml`** — Universal playbook. Iterates through all host groups and applies the matching role. Run with `-l` to restrict to one host, `-t` to restrict to one tag/role. The first play runs `common` on all `all_servers` and sets up Nagios NRPE client; the last play runs `backup` on all servers with `strategy: free`.
- **`users.yml`** — Separate playbook for user management (lives in the inventory directory, e.g. `example/users.yml`).
- **`new_guest.yml`** — Full KVM VM lifecycle: LVM volume → partition → ext4 → debootstrap OS install → GRUB → libvirt define/start → inventory registration.
- **`runrole.yml`** — Utility to apply a single role to a target host without editing site.yml.

### Role-to-Tag Mapping (site.yml)
Each host group in inventory maps to a role and a tag of the same base name. Examples: `bind_servers` → role `bind`, tag `bind`; `log_servers` → roles `java`, `elasticsearch`, `kibana`, `syslog-ng`, `logstash`, `curator`, tag `elk`.

### Variables Hierarchy
- `example/group_vars/all` — global defaults (domain, SSH port, SNMP, nameservers)
- `example/group_vars/<group>` — per-service overrides
- `example/host_vars/<host>` — per-host overrides
- `vars/<domain_slug>` — per-project sensitive vars loaded at runtime (gitignored)

### Custom Plugins
- `action_plugins/get_argv.py` — captures CLI `-e` extra-vars into an `argv` fact; used in `new_guest.yml` before the libvirt `define` block to pass runtime parameters into the XML template.

### Target OS
Primarily Debian (default `os_version: trixie`). Role `common` also supports Ubuntu xenial/yakkety and CentOS-7. Most other roles are Debian-only.
