https://github.com/ScoopInstaller/Install

The PowerShell [Execution Policy](https://learn.microsoft.com/en-us/powershell/module/microsoft.powershell.core/about/about_execution_policies) is required to be one of `RemoteSigned`, `Unrestricted` or `ByPass` to run the installer. For example, it can be set to `RemoteSigned` via:

```
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
``` 


Dann `install.ps1 -ScoopDir 'E:\Scoop' -ScoopGlobalDir 'E:\ScoopApps' -NoProxy` 
