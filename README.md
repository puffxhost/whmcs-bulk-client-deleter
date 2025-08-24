

<h1>WHMCS Bulk Client Deleter</h1>

<p>
  <img src="https://img.shields.io/badge/WHMCS-8.13%2B-blue" alt="WHMCS">
  <img src="https://img.shields.io/badge/status-active-success" alt="Status">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
</p>

<p>Bulk-select and remove multiple WHMCS client accounts in a single action. Designed for admins who need to quickly clean test accounts, inactive signups, or users with no products/services — safely and efficiently.</p>

<p><strong>⚠️ Safety first:</strong> Deletion is permanent. Always take a full database backup before using.</p>

<hr>

<h2>✨ Key Features</h2>
<ul>
  <li><strong>Multi-select deletion:</strong> Choose many clients and remove them in one go.</li>
  <li><strong>Filter: zero services:</strong> Quickly surface accounts with no products/services.</li>
  <li><strong>Filter: recent signups:</strong> Narrow to newly created client profiles.</li>
  <li><strong>Bulk select / deselect:</strong> Save time with select-all operations.</li>
  <li><strong>Audit preview:</strong> Review selected clients before confirming deletion.</li>
  <li><strong>Permission aware:</strong> Restrict access to specific admin roles.</li>
</ul>

<h2>🧰 Compatibility</h2>
<ul>
  <li><strong>WHMCS:</strong> v8.13+ (and newer)</li>
  <li><strong>PHP:</strong> 7.4 / 8.0 / 8.1 / 8.2</li>
  <li><strong>Database:</strong> MySQL/MariaDB (per WHMCS requirement)</li>
</ul>

<hr>



<h2>🚀 Installation</h2>
<ol>
  <li><strong>Download / Clone</strong> this repository.</li>
  <li><strong>Extract</strong> the folder to your WHMCS installation at:<br>
      <code>/modules/addons/deleteclients</code>
  </li>
  <li>In WHMCS, go to <strong>Setup → Addon Modules</strong>.</li>
  <li>Find <strong>Bulk Client Deleter</strong> and click <strong>Activate</strong>.</li>
  <li>Set <strong>Access Control</strong> (choose permitted admin roles).</li>
  <li>Navigate to <strong>Addons → Bulk Client Deleter</strong> to open the tool.</li>
</ol>

<p><em>Tip: Use a staging instance to test filters and confirm behavior.</em></p>

<hr>

<h2>⚙️ Usage</h2>
<ol>
  <li>Open <strong>Addons → Bulk Client Deleter</strong>.</li>
  <li>Apply filters:
    <ul>
      <li><strong>No Services</strong> → Show clients with 0 active/inactive products.</li>
      <li><strong>Recent Signups</strong> → Limit by a configurable number of days.</li>
    </ul>
  </li>
  <li><strong>Select</strong> clients (or <strong>Select All</strong>).</li>
  <li>Click <strong>Preview</strong> to audit the selection.</li>
  <li>Click <strong>Delete Selected</strong> and confirm.</li>
</ol>

<h3>What gets deleted?</h3>
<ul>
  <li>Client profile</li>
  <li>Related contacts</li>
  <li>Optional: invoices/transactions/tickets (depends on module settings)</li>
</ul>

<hr>

<h2>🗂️ Project Structure</h2>
<pre>
modules/
└─ addons/
   └─ deleteclients/
      ├─ lang/
      │   └─ english.php
      ├─ templates/
      │   └─ manage.tpl
      └─ deleteclients.php
├─ LICENSE
└─ README.html
</pre>

<hr>

<h2>🙋 Support</h2>
<ul>
  <li><strong>Issues:</strong> Open a GitHub issue</li>
  <li><strong>Feature requests:</strong> Open an enhancement issue</li>
  <li><strong>Security:</strong> Email maintainer privately</li>
</ul>

<hr>

<h2>📝 Changelog</h2>
<pre>
## [1.0.0] - 2025-08-17
### Added
- Initial release: bulk delete clients, zero-service filter, recent signup filter.
- Preview + confirmation flow.
- Role-based access.
</pre>

<hr>

<h2>🤝 Contributing</h2>
<ol>
  <li>Fork the repo</li>
  <li>Create a feature branch: <code>git checkout -b feat/your-feature</code></li>
  <li>Commit changes: <code>git commit -m "feat: add your feature"</code></li>
  <li>Push and open a PR</li>
</ol>

<hr>

<h2>🔐 Security Policy</h2>
<p>If you discover a vulnerability, <strong>do not</strong> open a public issue.<br>
Email your report to <em>[maintainer-email@example.com]</em>.</p>

<hr>

<h2>📄 License</h2>
<p>This project is licensed under the <strong>MIT License</strong>.</p>

</body>
</html>
