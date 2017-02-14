$TTL 86400
@ IN SOA ns.example.com. abuse.example.com. 2015021868 14400 14400 1209600 86400
@ NS ns.example.com.
@ NS ns2.example.com.
@ MX 10 mail.example.com.
ns A 1.1.1.1
ns2 A 2.2.2.2
mail A 1.2.3.4
@ A 1.2.3.4
* CNAME @
