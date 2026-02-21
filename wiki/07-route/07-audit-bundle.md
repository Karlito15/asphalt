php bin/console debug:router
--------------------------------- ---------- ------------ ------ -----------------------------------------------------
Name                              Method     Scheme       Host   Path
--------------------------------- ---------- ------------ ------ -----------------------------------------------------
dh_auditor_list_audits                    GET              ANY          /audit
dh_auditor_show_transaction               GET              ANY          /audit/transaction/{hash}
dh_auditor_show_entity_history            GET              ANY          /audit/{entity}/{id}
--------------------------------- ---------- ------------ ------ -----------------------------------------------------
