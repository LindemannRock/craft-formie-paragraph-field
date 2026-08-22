# Formie Paragraph Field tests

The suite covers only behavior owned by this package: typed settings hydration,
field defaulting, escaped rendering across builder/frontend/CP-submission/email
consumers, preview serialization, dependency metadata, and package-gate
orchestration. It does not duplicate Formie's generic field registration or
Craft's framework behavior.

Workspace runs use the existing DDEV Craft project and create no plugin-owned
database rows, queue jobs, Redis/cache keys, or durable files. Tests restore any
temporary singleton settings in `finally`; Base's harness owns its isolated
temporary cache. Orchestration fixtures use exact tracked temporary directories.

Standalone CI creates one disposable Craft project and an exact
`fpf_qg_<run-id>` database, installs Formie and this plugin, runs PHPUnit, then
drops that database and removes the project directory on success or failure.
The runner registers idempotent shutdown and signal cleanup, terminates any
active child command, and runs real ordinary-failure, shutdown, and SIGTERM
lifecycle probes against exact owned database/project pairs.
