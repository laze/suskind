# Introduction #
The Süskind Framework is designed to be easy to install, and easy to use and work with it. Naturally, because it's a web server program, you need [Apache](http://www.apache.org/) server and [PHP](http://php.net) to do anything with it. You can choose any of the handled database engines to use database for SF. (See: DatabaseResources)
Also if you install any other modules, then you have to check it's requirements, in that case, may be you should install other things.
# Installation #
## From our Repository ##
First of all: SF stored in SVN, so, you'll need any SVN (Subversion) client to get it. We assume, that it's installed, and usable via terminal.
```
svn checkout http://suskind.googlecode.com/svn/trunk/ .
```
## Structure of Folders and Files ##
After it's downloaded and copied, you have an empty but ready-to-use installation. It has every library to work, so here is the good time to know what you have.
  * `Assets` - Your project's assets.
  * `Configuration` - Project related configuration files.
    * `Suskind` - Suskind Library's configuration.
    * `Spyc` - [Spyc YAML parser.](http://code.google.com/p/spyc/)
    * `Doctrine` - [ORM provider library.](http://www.doctrine-project.org/)
  * `Library` - This is the most important folder. It contains every used library, included the Suskind Framework.
    * `Suskind`
  * `Resource` - Other resources, like i18n files, etc...
  * `Web` - The directory for the web server.
    * `index.php`
## Web Server Settings ##
To use the SF, you have to set up your web server too. The project's document root should point to `Web` folder, with the option to follow symbolic links and be able step out from this directory.
### Apache ###
If you use Apache, you can set up your application with a config file, as `my-application` in your Apache's `sites-available` directory:
```
# /etc/apache2/sites-available/my-application

NameVirtualHost *:80

<VirtualHost *:80>
	ServerName www.my-application.local
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/MyApplication/Web/
	<Directory />
		Options FollowSymLinks
		AllowOverride all
	</Directory>
	<Directory /var/www/MyApplication/Web/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride all
		Order allow,deny
		allow from all
	</Directory>
</VirtualHost>
```
Parallel this edition you also have to add a record for your `hosts` file, what is found somewhere in `/etc` folder.
```
# /etc/hosts

127.0.0.1    www.my-application.local
```
After these step, you just have to create a symbolic link in the `sites-enabled` folder.
```

$ cd /etc/apache2/sites-enabled

$ ln -s /etc/apache2/sites-available/my-application 000my-application

```
Finally, you just have to restart your apache.
```
$ apache2ctl restart
```
Now, you can reach your web based application at `http://www.my-applocation.local`
### Other Platforms ###
Other platforms not yet tested.