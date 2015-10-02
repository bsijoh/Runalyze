<?php
$CLASSMAP = array(
'AdminView' => 'class.AdminView.php',
'DataBrowser' => 'class.DataBrowser.php',
'DataBrowserLinker' => 'class.DataBrowserLinker.php',
'DataBrowserShared' => 'class.DataBrowserShared.php',
'Dataset' => 'class.Dataset.php',
'DatasetLabels' => 'class.DatasetLabels.php',
'Frontend' => 'class.Frontend.php',
'FrontendShared' => 'class.FrontendShared.php',
'FrontendSharedList' => 'class.FrontendSharedList.php',
'FrontendSharedStatistics' => 'class.FrontendSharedStatistics.php',
'Helper' => 'class.Helper.php',
'Installer' => 'class.Installer.php',
'InstallerUpdate' => 'class.InstallerUpdate.php',
'Splits' => 'data/class.Splits.php',
'Sport' => 'data/class.Sport.php',
'SportFactory' => 'data/class.SportFactory.php',
'Type' => 'data/class.Type.php',
'TypeFactory' => 'data/class.TypeFactory.php',
'UserData' => 'data/class.UserData.php',
'GpsData' => 'data/gps/class.GpsData.php',
'SRTMGeoTIFFReader' => 'data/gps/class.SRTMGeoTIFFReader.php',
'Plot' => 'draw/class.Plot.php',
'PlotMonthSumData' => 'draw/class.PlotMonthSumData.php',
'PlotSumData' => 'draw/class.PlotSumData.php',
'PlotWeekSumData' => 'draw/class.PlotWeekSumData.php',
'ExporterAbstract' => 'export/class.ExporterAbstract.php',
'ExporterAbstractFile' => 'export/class.ExporterAbstractFile.php',
'ExporterAbstractSocialShare' => 'export/class.ExporterAbstractSocialShare.php',
'ExporterFactory' => 'export/class.ExporterFactory.php',
'ExporterListView' => 'export/class.ExporterListView.php',
'ExporterType' => 'export/class.ExporterType.php',
'ExporterWindow' => 'export/class.ExporterWindow.php',
'ExporterFacebook' => 'export/types/class.ExporterFacebook.php',
'ExporterFITLOG' => 'export/types/class.ExporterFITLOG.php',
'ExporterGoogle' => 'export/types/class.ExporterGoogle.php',
'ExporterGPX' => 'export/types/class.ExporterGPX.php',
'ExporterHTML' => 'export/types/class.ExporterHTML.php',
'ExporterIFrame' => 'export/types/class.ExporterIFrame.php',
'ExporterKML' => 'export/types/class.ExporterKML.php',
'ExporterTCX' => 'export/types/class.ExporterTCX.php',
'ExporterTwitter' => 'export/types/class.ExporterTwitter.php',
'Ajax' => 'html/class.Ajax.php',
'AjaxTabs' => 'html/class.AjaxTabs.php',
'BlocklinkList' => 'html/class.BlocklinkList.php',
'BoxedValue' => 'html/class.BoxedValue.php',
'HTML' => 'html/class.HTML.php',
'HTMLMetaForFacebook' => 'html/class.HTMLMetaForFacebook.php',
'HtmlTag' => 'html/class.HtmlTag.php',
'Icon' => 'html/class.Icon.php',
'ProgressBar' => 'html/class.ProgressBar.php',
'ProgressBarSingle' => 'html/class.ProgressBarSingle.php',
'Formular' => 'html/formular/class.Formular.php',
'FormularCheckbox' => 'html/formular/class.FormularCheckbox.php',
'FormularCheckboxes' => 'html/formular/class.FormularCheckboxes.php',
'FormularField' => 'html/formular/class.FormularField.php',
'FormularFieldset' => 'html/formular/class.FormularFieldset.php',
'FormularInput' => 'html/formular/class.FormularInput.php',
'FormularInputDate' => 'html/formular/class.FormularInputDate.php',
'FormularInputDayAndDaytime' => 'html/formular/class.FormularInputDayAndDaytime.php',
'FormularInputHidden' => 'html/formular/class.FormularInputHidden.php',
'FormularInputNumber' => 'html/formular/class.FormularInputNumber.php',
'FormularInputPassword' => 'html/formular/class.FormularInputPassword.php',
'FormularInputWithEqualityOption' => 'html/formular/class.FormularInputWithEqualityOption.php',
'FormularSelectBox' => 'html/formular/class.FormularSelectBox.php',
'FormularSelectDb' => 'html/formular/class.FormularSelectDb.php',
'FormularSubmit' => 'html/formular/class.FormularSubmit.php',
'FormularTextarea' => 'html/formular/class.FormularTextarea.php',
'FormularUnit' => 'html/formular/class.FormularUnit.php',
'FormularValueParser' => 'html/formular/class.FormularValueParser.php',
'StandardFormular' => 'html/formular/class.StandardFormular.php',
'StandardFormularFieldFactory' => 'html/formular/class.StandardFormularFieldFactory.php',
'StandardFormularFieldsetFactory' => 'html/formular/class.StandardFormularFieldsetFactory.php',
'ImporterFactory' => 'import/class.ImporterFactory.php',
'ImporterUpload' => 'import/class.ImporterUpload.php',
'ImporterWindow' => 'import/class.ImporterWindow.php',
'ImporterWindowTab' => 'import/class.ImporterWindowTab.php',
'ImporterWindowTabCommunicator' => 'import/class.ImporterWindowTabCommunicator.php',
'ImporterWindowTabFormular' => 'import/class.ImporterWindowTabFormular.php',
'ImporterWindowTabUpload' => 'import/class.ImporterWindowTabUpload.php',
'MultiEditor' => 'import/class.MultiEditor.php',
'MultiImporter' => 'import/class.MultiImporter.php',
'MultiImporterFormular' => 'import/class.MultiImporterFormular.php',
'ImporterFiletypeAbstract' => 'import/filetypes/class.ImporterFiletypeAbstract.php',
'ImporterFiletypeCSV' => 'import/filetypes/class.ImporterFiletypeCSV.php',
'ImporterFiletypeFIT' => 'import/filetypes/class.ImporterFiletypeFIT.php',
'ImporterFiletypeFITLOG' => 'import/filetypes/class.ImporterFiletypeFITLOG.php',
'ImporterFiletypeGPX' => 'import/filetypes/class.ImporterFiletypeGPX.php',
'ImporterFiletypeHRM' => 'import/filetypes/class.ImporterFiletypeHRM.php',
'ImporterFiletypeKML' => 'import/filetypes/class.ImporterFiletypeKML.php',
'ImporterFiletypeLOGBOOK' => 'import/filetypes/class.ImporterFiletypeLOGBOOK.php',
'ImporterFiletypeLOGBOOK3' => 'import/filetypes/class.ImporterFiletypeLOGBOOK3.php',
'ImporterFiletypePWX' => 'import/filetypes/class.ImporterFiletypePWX.php',
'ImporterFiletypeSLF' => 'import/filetypes/class.ImporterFiletypeSLF.php',
'ImporterFiletypeSML' => 'import/filetypes/class.ImporterFiletypeSML.php',
'ImporterFiletypeTCX' => 'import/filetypes/class.ImporterFiletypeTCX.php',
'ImporterFiletypeTRK' => 'import/filetypes/class.ImporterFiletypeTRK.php',
'ImporterFiletypeTTBIN' => 'import/filetypes/class.ImporterFiletypeTTBIN.php',
'ImporterFiletypeXML' => 'import/filetypes/class.ImporterFiletypeXML.php',
'ImporterFiletypeZIP' => 'import/filetypes/class.ImporterFiletypeZIP.php',
'ImporterHRMandGPX' => 'import/filetypes/class.ImporterHRMandGPX.php',
'ParserAbstract' => 'import/parser/class.ParserAbstract.php',
'ParserAbstractMultiple' => 'import/parser/class.ParserAbstractMultiple.php',
'ParserAbstractMultipleXML' => 'import/parser/class.ParserAbstractMultipleXML.php',
'ParserAbstractSingle' => 'import/parser/class.ParserAbstractSingle.php',
'ParserAbstractSingleXML' => 'import/parser/class.ParserAbstractSingleXML.php',
'ParserCSVepsonSingle' => 'import/parser/class.ParserCSVepsonSingle.php',
'ParserFITLOGMultiple' => 'import/parser/class.ParserFITLOGMultiple.php',
'ParserFITLOGSingle' => 'import/parser/class.ParserFITLOGSingle.php',
'ParserFITMultiple' => 'import/parser/class.ParserFITMultiple.php',
'ParserFITSingle' => 'import/parser/class.ParserFITSingle.php',
'ParserGPXMultiple' => 'import/parser/class.ParserGPXMultiple.php',
'ParserGPXSingle' => 'import/parser/class.ParserGPXSingle.php',
'ParserHRMSingle' => 'import/parser/class.ParserHRMSingle.php',
'ParserKMLSingle' => 'import/parser/class.ParserKMLSingle.php',
'ParserKMLtomtomMultiple' => 'import/parser/class.ParserKMLtomtomMultiple.php',
'ParserKMLtomtomSingle' => 'import/parser/class.ParserKMLtomtomSingle.php',
'ParserLOGBOOKMultiple' => 'import/parser/class.ParserLOGBOOKMultiple.php',
'ParserLOGBOOKSingle' => 'import/parser/class.ParserLOGBOOKSingle.php',
'ParserPWXMultiple' => 'import/parser/class.ParserPWXMultiple.php',
'ParserPWXSingle' => 'import/parser/class.ParserPWXSingle.php',
'ParserSLF3Multiple' => 'import/parser/class.ParserSLF3Multiple.php',
'ParserSLF3Single' => 'import/parser/class.ParserSLF3Single.php',
'ParserSLF4Multiple' => 'import/parser/class.ParserSLF4Multiple.php',
'ParserSLF4Single' => 'import/parser/class.ParserSLF4Single.php',
'ParserSMLsuuntoMultiple' => 'import/parser/class.ParserSMLsuuntoMultiple.php',
'ParserSMLsuuntoSingle' => 'import/parser/class.ParserSMLsuuntoSingle.php',
'ParserTCXMultiple' => 'import/parser/class.ParserTCXMultiple.php',
'ParserTCXruntasticMultiple' => 'import/parser/class.ParserTCXruntasticMultiple.php',
'ParserTCXruntasticSingle' => 'import/parser/class.ParserTCXruntasticSingle.php',
'ParserTCXSingle' => 'import/parser/class.ParserTCXSingle.php',
'ParserTCXSingleCourse' => 'import/parser/class.ParserTCXSingleCourse.php',
'ParserTRKSingle' => 'import/parser/class.ParserTRKSingle.php',
'ParserXMLpolarMultiple' => 'import/parser/class.ParserXMLpolarMultiple.php',
'ParserXMLpolarSingle' => 'import/parser/class.ParserXMLpolarSingle.php',
'ParserXMLrunningAHEADMultiple' => 'import/parser/class.ParserXMLrunningAHEADMultiple.php',
'ParserXMLrunningAHEADSingle' => 'import/parser/class.ParserXMLrunningAHEADSingle.php',
'ParserXMLsuuntoMultiple' => 'import/parser/class.ParserXMLsuuntoMultiple.php',
'ParserXMLsuuntoSingle' => 'import/parser/class.ParserXMLsuuntoSingle.php',
'ParserZIP' => 'import/parser/class.ParserZIP.php',
'Plugin' => 'plugin/class.Plugin.php',
'PluginFactory' => 'plugin/class.PluginFactory.php',
'PluginInstaller' => 'plugin/class.PluginInstaller.php',
'PluginPanel' => 'plugin/class.PluginPanel.php',
'PluginStat' => 'plugin/class.PluginStat.php',
'PluginTool' => 'plugin/class.PluginTool.php',
'PluginType' => 'plugin/class.PluginType.php',
'PluginConfiguration' => 'plugin/config/class.PluginConfiguration.php',
'PluginConfigurationValue' => 'plugin/config/class.PluginConfigurationValue.php',
'PluginConfigurationValueArray' => 'plugin/config/class.PluginConfigurationValueArray.php',
'PluginConfigurationValueBool' => 'plugin/config/class.PluginConfigurationValueBool.php',
'PluginConfigurationValueFloat' => 'plugin/config/class.PluginConfigurationValueFloat.php',
'PluginConfigurationValueHiddenArray' => 'plugin/config/class.PluginConfigurationValueHiddenArray.php',
'PluginConfigurationValueInt' => 'plugin/config/class.PluginConfigurationValueInt.php',
'PluginConfigurationValueSelect' => 'plugin/config/class.PluginConfigurationValueSelect.php',
'PluginConfigurationWindow' => 'plugin/config/class.PluginConfigurationWindow.php',
'AccountHandler' => 'system/class.AccountHandler.php',
'Autoloader' => 'system/class.Autoloader.php',
'Benchmark' => 'system/class.Benchmark.php',
'Cache' => 'system/class.Cache.php',
'DatabaseScheme' => 'system/class.DatabaseScheme.php',
'DatabaseSchemePool' => 'system/class.DatabaseSchemePool.php',
'DataObject' => 'system/class.DataObject.php',
'DB' => 'system/class.DB.php',
'Error' => 'system/class.Error.php',
'Filesystem' => 'system/class.Filesystem.php',
'Language' => 'system/class.Language.php',
'PDOforRunalyze' => 'system/class.PDOforRunalyze.php',
'Request' => 'system/class.Request.php',
'SessionAccountHandler' => 'system/class.SessionAccountHandler.php',
'SharedLinker' => 'system/class.SharedLinker.php',
'System' => 'system/class.System.php',
'ConfigTab' => 'system/config/class.ConfigTab.php',
'ConfigTabAccount' => 'system/config/class.ConfigTabAccount.php',
'ConfigTabDataset' => 'system/config/class.ConfigTabDataset.php',
'ConfigTabEquipment' => 'system/config/class.ConfigTabEquipment.php',
'ConfigTabGeneral' => 'system/config/class.ConfigTabGeneral.php',
'ConfigTabPlugins' => 'system/config/class.ConfigTabPlugins.php',
'ConfigTabs' => 'system/config/class.ConfigTabs.php',
'ConfigTabSports' => 'system/config/class.ConfigTabSports.php',
'ConfigTabTypes' => 'system/config/class.ConfigTabTypes.php',
'PerlCommand' => 'system/shell/class.PerlCommand.php',
'Shell' => 'system/shell/class.Shell.php',
'ShellCommand' => 'system/shell/class.ShellCommand.php',
'TrainingFormular' => 'training/class.TrainingFormular.php',
'TrainingObject' => 'training/class.TrainingObject.php',
'TrainingInputSplits' => 'training/formular/class.TrainingInputSplits.php',
'TrainingSelectEquipment' => 'training/formular/class.TrainingSelectEquipment.php',
'TrainingSelectSport' => 'training/formular/class.TrainingSelectSport.php',
'TrainingSelectType' => 'training/formular/class.TrainingSelectType.php',
'TrainingSelectWeather' => 'training/formular/class.TrainingSelectWeather.php',
'FormularInputSearchTimeRange' => 'training/search/class.FormularInputSearchTimeRange.php',
'FormularSelectSearchSort' => 'training/search/class.FormularSelectSearchSort.php',
'SearchFormular' => 'training/search/class.SearchFormular.php',
'SearchLink' => 'training/search/class.SearchLink.php',
'SearchResults' => 'training/search/class.SearchResults.php',
'ElevationInfo' => 'training/view/class.ElevationInfo.php',
'TrainingView' => 'training/view/class.TrainingView.php',
'TrainingViewIFrame' => 'training/view/class.TrainingViewIFrame.php',
'TrainingViewSection' => 'training/view/class.TrainingViewSection.php',
'TrainingViewSectionRow' => 'training/view/class.TrainingViewSectionRow.php',
'TrainingViewSectionRowAbstract' => 'training/view/class.TrainingViewSectionRowAbstract.php',
'TrainingViewSectionRowFullwidth' => 'training/view/class.TrainingViewSectionRowFullwidth.php',
'TrainingViewSectionRowOnlyText' => 'training/view/class.TrainingViewSectionRowOnlyText.php',
'TrainingViewSectionRowTabbedPlot' => 'training/view/class.TrainingViewSectionRowTabbedPlot.php',
'TrainingViewSectionTabbed' => 'training/view/class.TrainingViewSectionTabbed.php',
'TrainingViewSectionTabbedPlot' => 'training/view/class.TrainingViewSectionTabbedPlot.php',
'VDOTinfo' => 'training/view/class.VDOTinfo.php',
'SectionComposite' => 'training/view/section/class.SectionComposite.php',
'SectionCompositeRow' => 'training/view/section/class.SectionCompositeRow.php',
'SectionHeartrate' => 'training/view/section/class.SectionHeartrate.php',
'SectionHeartrateRow' => 'training/view/section/class.SectionHeartrateRow.php',
'SectionHRV' => 'training/view/section/class.SectionHRV.php',
'SectionHRVRow' => 'training/view/section/class.SectionHRVRow.php',
'SectionLaps' => 'training/view/section/class.SectionLaps.php',
'SectionLapsRowComputed' => 'training/view/section/class.SectionLapsRowComputed.php',
'SectionLapsRowManual' => 'training/view/section/class.SectionLapsRowManual.php',
'SectionMiscellaneous' => 'training/view/section/class.SectionMiscellaneous.php',
'SectionMiscellaneousRow' => 'training/view/section/class.SectionMiscellaneousRow.php',
'SectionOverview' => 'training/view/section/class.SectionOverview.php',
'SectionOverviewRow' => 'training/view/section/class.SectionOverviewRow.php',
'SectionPace' => 'training/view/section/class.SectionPace.php',
'SectionPaceRow' => 'training/view/section/class.SectionPaceRow.php',
'SectionRoute' => 'training/view/section/class.SectionRoute.php',
'SectionRouteOnlyElevation' => 'training/view/section/class.SectionRouteOnlyElevation.php',
'SectionRouteOnlyMap' => 'training/view/section/class.SectionRouteOnlyMap.php',
'SectionRouteRowElevation' => 'training/view/section/class.SectionRouteRowElevation.php',
'SectionRouteRowMap' => 'training/view/section/class.SectionRouteRowMap.php',
'SectionRunningDynamics' => 'training/view/section/class.SectionRunningDynamics.php',
'SectionRunningDynamicsRow' => 'training/view/section/class.SectionRunningDynamicsRow.php',
'SectionSwimLane' => 'training/view/section/class.SectionSwimLane.php',
'SectionSwimLaneRow' => 'training/view/section/class.SectionSwimLaneRow.php',
'TableLaps' => 'training/view/section/table/class.TableLaps.php',
'TableLapsAbstract' => 'training/view/section/table/class.TableLapsAbstract.php',
'TableLapsComputed' => 'training/view/section/table/class.TableLapsComputed.php',
'TableSwimLane' => 'training/view/section/table/class.TableSwimLane.php',
'TableZonesAbstract' => 'training/view/section/table/class.TableZonesAbstract.php',
'TableZonesHeartrate' => 'training/view/section/table/class.TableZonesHeartrate.php',
'TableZonesPace' => 'training/view/section/table/class.TableZonesPace.php',
);