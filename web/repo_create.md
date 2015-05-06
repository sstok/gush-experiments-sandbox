---
layout: docu-page
full_title: "Gush: Rapid workflow for project maintainers and contributors"
---
{% block content %}
repo:create
-----------

* Description: Quickly spins a repository
* Usage:

  * `repo:create <name> [<description>] [<homepage>]`

The <info>repo:create</info> command spins a repository:

    <info>$ gush repo:create my-package</info>


### Arguments:

**name:**

* Name: name
* Is required: yes
* Is array: no
* Description: Name of the new repository
* Default: `NULL`

**description:**

* Name: description
* Is required: no
* Is array: no
* Description: Repository description
* Default: `NULL`

**homepage:**

* Name: homepage
* Is required: no
* Is array: no
* Description: Repository homepage
* Default: `NULL`
{% endblock %}