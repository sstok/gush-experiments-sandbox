---
layout: docu-page
full_title: "Gush: Rapid workflow for project maintainers and contributors"
---
{% block content %}
branch:remote:add
-----------------

* Description: Adds a remote with url used from adapter
* Usage:

  * `branch:remote:add [<other_organization>] [<other_repository>] [<remote>]`

The <info>branch:remote:add</info> command adds a remote with url used from adapter:

    <info>$ gush branch:remote:add sstok gush</info>

    , note that this overwrite any existing remote with the same name!


### Arguments:

**other_organization:**

* Name: other_organization
* Is required: no
* Is array: no
* Description: Organization or username the remote will point to
* Default: `NULL`

**other_repository:**

* Name: other_repository
* Is required: no
* Is array: no
* Description: Repository-name the remote will point to
* Default: `NULL`

**remote:**

* Name: remote
* Is required: no
* Is array: no
* Description: Remote name, when not provided the other_organization is used as remote-name
* Default: `NULL`
{% endblock %}