# <ProjectName> E-Shop

## Installation

0. Clone repository and run composer install

	```
	git clone -b develop <git-url> <project-name>
	cd <project-name>
	composer install
	```

0. Execute [mg2-builder](https://github.com/staempfli/magento2-builder-tool) task to setup a new project:

    ```
    bin/mg2-builder install
    ```

0. Set the new host (skip if you have dnsmask configured for .lo):
	* `sudo vim /etc/hosts`
	* add `127.0.0.1 <project-name>.lo`

0. Restart Apache

## Updates

### Update Project

* `bin/mg2-builder update`

### Update Database and Media

* `bin/mg2-builder sync`

## Frontend

* [Frontend Documentation](docs/development/frontend.md)
