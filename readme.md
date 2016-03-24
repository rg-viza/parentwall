# PW Whitelisting Gateway Manager

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

PW Whitelisting Gateway Manager is an interface for managing whitelists and system services in a new type of network security device.
Built on the laravel framework, it's very easy to extend, maintain and work on. It currently supports iptables and a custom version of tinyproxy.

The interface is responsively designed for mobile devices or computers. Utilizing email and an intuitive interface, it will allow users to completely lock down their 
home/office network using the "Default Deny" security paradigm. What's different about PWWGM is that it will be so easy to use that my mom can use it, yet give fine grained control over 
what is allowed to enter and leave your network. Out of the box there will be access packs to allow common mainstream sites, services etc  to work with a simple checklist 
interface.

The use case is the owner sets up the device. The user tries to access a site. If the site hasn't been explicitly allowed, it denies acces and give the user the 
opportunity to start a workflow to get the site added to the white list. Once requested the owner gets an email with a link to the request. At that time the owner
can preview the site on their device. They can then "Allow all" source domains, permanently blacklist the site (so they never get bothered with it again)
or pick and choose the resource domains within the page they wish to allow.

All of the source domains allowed are then compared against the malicious/advertising blacklists and anything on a blacklist is silently tossed into the bitbucket.

The whitelists are set up per user and the administrator can allow a given site for only one user or use a picklist to pick users.

## To Do

Currently only the dashboard with service statuses/control are implemented in this laravel interface. 
The interface, running on lighttpd, supports iptables and tinyproxy service management on Arch using systemctl.

Short Term 
I plan to add my working code from the alpha build for domain, user and firewall management from my Yoggie, incorporate it into the Laravel, get the whole appliance working in a VM,
then do a stripped down Raspberry Pi port.

Mid Term
Build "Access Packs" for broad categories of sites which I have deemed to be safe such as:
Fortune 500 companies
Mainstream media outlets
Search engines
Children's sites
Retailers

Long Term
TBD

## Official Documentation

To Do

## Contributing

To Do

## Security Vulnerabilities

If you discover a security vulnerability within PWWGM, please send an e-mail to Neil Davis at rg.viza@gmail.com. All security vulnerabilities will be promptly addressed.

## License

BSD
